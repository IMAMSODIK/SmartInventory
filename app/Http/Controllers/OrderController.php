<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\ProfileUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;

class OrderController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        return sqrt(pow($lat1 - $lat2, 2) + pow($lon1 - $lon2, 2));
    }

    private function findNearestDriver($store)
    {
        return Driver::all()->map(function ($driver) use ($store) {

            $distance = sqrt(
                pow($store->latitude - $driver->latitude, 2) +
                    pow($store->longitude - $driver->longitude, 2)
            );

            $driver->distance = $distance;

            return $driver;
        })->sortBy('distance')->first();
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            $buyer = Auth::user();
            $orderId = 'ORDER-' . Str::uuid();

            $grossAmount = 0;
            $shippingCost = 0;
            $itemDetails = [];

            // 🔥 AMBIL ALAMAT DEFAULT
            $alamat = Alamat::where('user_id', $buyer->id)
                ->where('is_default', true)
                ->first();

            if (!$alamat) {
                return response()->json([
                    'message' => 'Pilih alamat default terlebih dahulu'
                ], 422);
            }

            // 🔥 GROUP PRODUK PER TOKO
            $grouped = [];

            foreach ($request->items as $item) {

                $produk = Produk::with('profileUsaha')->findOrFail($item['id']);

                $storeId = $produk->profile_usaha_id;

                $grouped[$storeId][] = [
                    'produk' => $produk,
                    'qty' => $item['qty'],
                    'note' => $item['note'] ?? null
                ];
            }

            // 🔥 BUAT ORDER
            $order = Order::create([
                'order_id' => $orderId,
                'buyer_id' => $buyer->id,
                'alamat_id' => $alamat->id,
                'status' => 'pending',
                'shipping_cost' => 0,
                'total' => 0,
            ]);

            // 🔥 LOOP PER TOKO
            foreach ($grouped as $storeId => $items) {

                $store = ProfileUsaha::findOrFail($storeId);

                // 🔥 HITUNG JARAK
                $distance = $this->calculateDistance(
                    $store->latitude,
                    $store->longitude,
                    $alamat->latitude,
                    $alamat->longitude
                );

                // 🔥 ONGKIR (simple)
                $ongkir = $distance * 2000; // 2rb/km
                $shippingCost += $ongkir;

                // 🔥 CARI DRIVER TERDEKAT
                $driver = $this->findNearestDriver($store);

                if (!$driver) {
                    DB::rollBack(); // penting biar gak ada data nyangkut

                    return response()->json([
                        'message' => 'Tidak ada driver di area ini'
                    ], 422);
                }

                foreach ($items as $item) {

                    $produk = $item['produk'];

                    $price = (int) $produk->price;
                    $qty = (int) $item['qty'];

                    $subtotal = $price * $qty;
                    $grossAmount += $subtotal;

                    // 🔥 SIMPAN ORDER ITEM
                    OrderItem::create([
                        'order_id' => $order->id,
                        'produk_id' => $produk->id,
                        'nama_produk' => $produk->name,
                        'harga' => $price,
                        'qty' => $qty,
                        'note' => $item['note'],
                        'driver_id' => $driver?->id, // 🔥 driver assign
                    ]);

                    // 🔥 MIDTRANS ITEM
                    $itemDetails[] = [
                        'id' => $produk->id,
                        'price' => $price,
                        'quantity' => $qty,
                        'name' => $produk->name
                    ];
                }
            }

            $total = $grossAmount + $shippingCost;

            $order->update([
                'total' => $total,
                'shipping_cost' => round($shippingCost)
            ]);
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $total,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $buyer->name,
                    'email' => $buyer->email,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            DB::commit();

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'total' => $total,
                'shipping_cost' => $shippingCost
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Checkout gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus($orderId)
    {
        $order = Order::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json([
            'status' => $order->status
        ]);
    }

    public function index()
    {
        return view('order.index', [
            'pageTitle' => 'Orders'
        ]);
    }

    public function data(Request $request)
    {
        try {

            $user = auth()->user();

            $query = Order::with(['buyer', 'orderItem.produk'])
                ->whereHas('orderItem.produk', function ($q) use ($user) {
                    $q->where('profile_usaha_id', $user->profileUsaha->id);
                });

            if ($request->status == 'done') {
                $query->where('status', 'delivered');
            } else {
                $query->whereIn('status', ['pending', 'paid', 'processing', 'shipping']);
            }

            $orders = $query->latest()->get();

            $data = $orders->map(function ($order) use ($user) {

                $items = $order->orderItem->filter(function ($item) use ($user) {
                    return $item->produk->profile_usaha_id == $user->profileUsaha->id;
                });

                return [
                    'id' => $order->id,
                    'order_id' => $order->order_id,
                    'buyer_name' => $order->buyer->name,
                    'item_summary' => $items->count() . ' item (' . $items->sum('qty') . ' pcs)',
                    'total' => $items->sum(fn($i) => $i->harga * $i->qty),
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('d M H:i')
                ];
            });

            return response()->json([
                'data' => $data
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function detail($id)
    {
        try {

            $user = auth()->user();

            $order = Order::with(['buyer', 'orderItem.produk'])
                ->findOrFail($id);

            // 🔥 ambil item milik pedagang ini saja
            $items = $order->orderItem->filter(function ($item) use ($user) {
                return $item->produk->profile_usaha_id == $user->profileUsaha->id;
            });

            return response()->json([
                'order_id' => $order->order_id,
                'buyer' => $order->buyer->name,
                'status' => $order->status,
                'items' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'produk' => $item->nama_produk,
                        'qty' => $item->qty,
                        'harga' => $item->harga,
                        'status' => $item->status
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal ambil detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {

            $request->validate([
                'item_id' => 'required|exists:order_items,id',
                'status' => 'required|in:processing,shipping,delivered'
            ]);

            $item = OrderItem::findOrFail($request->item_id);

            $item->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal update status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function restore($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);
    //         $user->status = true;
    //         $user->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data berhasil dikembalikan'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal mengembalikan data'
    //         ], 500);
    //     }
    // }

    public function destroy($id)
    {
        try {

            $order = Order::findOrFail($id);

            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order berhasil dihapus'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal hapus',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
