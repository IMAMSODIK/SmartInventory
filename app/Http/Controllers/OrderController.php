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
        \Midtrans\Config::$appendNotifUrl = config('midtrans.notification_url');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    private function findNearestDriver($store)
    {
        $drivers = Driver::with('user')
            ->where('is_online', true)
            ->where('is_available', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        if ($drivers->isEmpty()) {
            return null;
        }

        $nearest = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($drivers as $driver) {

            $distance = $this->calculateDistance(
                $store->latitude,
                $store->longitude,
                $driver->latitude,
                $driver->longitude
            );

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearest = $driver;
            }
        }

        return $nearest;
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
            $driverInfo = null;

            // ✅ Ambil alamat default
            $alamat = Alamat::where('user_id', $buyer->id)
                ->where('is_default', true)
                ->first();

            if (!$alamat) {
                return response()->json([
                    'message' => 'Pilih alamat default terlebih dahulu'
                ], 422);
            }

            // ✅ GROUP PER TOKO
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

            // ✅ CREATE ORDER
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

                // 🔥 HITUNG JARAK (KM)
                $distance = $this->calculateDistance(
                    $store->latitude,
                    $store->longitude,
                    $alamat->latitude,
                    $alamat->longitude
                );

                // 🔥 ONGKIR
                $ongkir = round($distance * 2000);
                $shippingCost += $ongkir;

                // 🔥 DRIVER TERDEKAT
                $driver = $this->findNearestDriver($store);

                if (!$driver) {
                    DB::rollBack();
                    return response()->json([
                        'message' => 'Tidak ada driver tersedia di area ini'
                    ], 422);
                }

                // 🔥 LOCK DRIVER
                $driver->update([
                    'is_available' => false
                ]);

                // 🔥 INFO DRIVER (ambil 1 saja)
                if (!$driverInfo) {
                    $driverInfo = [
                        'name' => $driver->user->name ?? 'Driver',
                        'rating' => $driver->rating,
                        'vehicle' => $driver->vehicle_type
                    ];
                }

                foreach ($items as $item) {

                    $produk = $item['produk'];

                    $price = (int) $produk->price;
                    $qty = (int) $item['qty'];

                    $subtotal = $price * $qty;
                    $grossAmount += $subtotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'produk_id' => $produk->id,
                        'nama_produk' => $produk->name,
                        'harga' => $price,
                        'qty' => $qty,
                        'note' => $item['note'],
                        'driver_id' => $driver->id,
                        'delivery_status' => 'assigned' // 🔥 penting
                    ]);

                    $itemDetails[] = [
                        'id' => $produk->id,
                        'price' => $price,
                        'quantity' => $qty,
                        'name' => $produk->name
                    ];
                }
            }

            // 🔥 TOTAL
            $total = round($grossAmount + $shippingCost);

            $order->update([
                'total' => $total,
                'shipping_cost' => $shippingCost
            ]);

            $itemDetails[] = [
                'id' => 'ONGKIR',
                'price' => (int) $shippingCost,
                'quantity' => 1,
                'name' => 'Ongkos Kirim'
            ];

            // 🔥 MIDTRANS
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
                'callbacks' => [
                    'finish' =>
                    'https://smart-inventory.forumrektorptkin2026.com/payment-success'
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            DB::commit();

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
                'ongkir' => $shippingCost,
                'total' => $total,
                'driver' => $driverInfo
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

    public function orderDetail($id)
    {
        $order = Order::with('orderItem')
            ->findOrFail($id);

        return response()->json([
            'items' => $order->items
        ]);
    }

    public function completeOrder(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $order = Order::with('orderItem')
                ->findOrFail($id);

            // UPDATE ORDER
            $order->update([
                'status' => 'delivered',
                'is_reviewed' => true
            ]);

            // DRIVER
            $driverId = $order->orderItem
                ->first()
                ->driver_id;

            DB::table('rating_drivers')->insert([

                'order_id' => $order->id,

                'driver_id' => $driverId,

                'buyer_id' => auth()->id(),

                'rating' => $request->driver_rating,

                'review' => $request->driver_review,

                'created_at' => now(),

                'updated_at' => now()

            ]);

            // PRODUK
            foreach ($request->produk_ratings as $item) {

                $orderItem = OrderItem::find($item['order_item_id']);

                DB::table('rating_produks')->insert([

                    'order_item_id' => $orderItem->id,

                    'produk_id' => $orderItem->produk_id,

                    'buyer_id' => auth()->id(),

                    'rating' => $item['rating'],

                    'review' => $item['review'],

                    'created_at' => now(),

                    'updated_at' => now()

                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Pesanan selesai & rating berhasil dikirim'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
