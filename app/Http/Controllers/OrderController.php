<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
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

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {

            $grossAmount = 0;
            $itemDetails = [];
            $orderId = 'ORDER-' . Str::uuid();

            $buyer = Auth::user();

            // 🔥 WAJIB ADA
            $alamat = Alamat::where('user_id', $buyer->id)
                ->where('is_default', true)
                ->first();

            if (!$alamat) {
                return response()->json([
                    'message' => 'Pilih alamat default terlebih dahulu'
                ], 422);
            }

            // 🔥 CREATE ORDER
            $order = Order::create([
                'order_id' => $orderId,
                'buyer_id' => $buyer->id,
                'alamat_id' => $alamat->id,
                'status' => 'pending',
                'shipping_cost' => 0,
                'total' => 0,
            ]);

            foreach ($request->items as $item) {

                $produk = Produk::findOrFail($item['id']);

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
                    'note' => $item['note'] ?? null
                ]);

                // 🔥 MIDTRANS
                $itemDetails[] = [
                    'id' => $produk->id,
                    'price' => $price,
                    'quantity' => $qty,
                    'name' => $produk->name
                ];
            }

            // 🔥 UPDATE TOTAL
            $order->update([
                'total' => $grossAmount
            ]);

            // 🔥 PARAM MIDTRANS
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $grossAmount,
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
                'order_id' => $orderId
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

    public function data()
    {
        try {
            $user = auth()->user();

            // 🔥 ambil order sesuai produk milik pedagang
            $orders = Order::with(['buyer', 'orderItem.produk'])
                ->whereHas('orderItem.produk', function ($q) use ($user) {
                    $q->where('profile_usaha_id', $user->profileUsaha->id);
                })
                ->whereIn('status', ['pending', 'paid', 'processing', 'shipping'])
                ->latest()
                ->get();

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
                'message' => 'Gagal mengambil data order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function detail($id)
    {
        try {

            $user = auth()->user();

            $order = Order::with(['buyer', 'orderItems.produk'])
                ->findOrFail($id);

            // 🔥 ambil item milik pedagang ini saja
            $items = $order->orderItems->filter(function ($item) use ($user) {
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

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name'  => 'required|max:100',
    //         'email' => 'required|email|unique:users,email',
    //         'role'  => 'required',
    //         'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ], [
    //         'name.required'  => 'Nama wajib diisi',
    //         'email.required' => 'Email wajib diisi',
    //         'email.unique'   => 'Email sudah digunakan',
    //         'role.required'  => 'Role wajib dipilih',
    //         'foto.image'     => 'File harus berupa gambar',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors'  => $validator->errors()
    //         ], 422);
    //     }

    //     try {
    //         $fotoPath = null;

    //         // upload foto jika ada
    //         if ($request->hasFile('foto')) {
    //             $fotoPath = $request->file('foto')->store('users', 'public');
    //         }

    //         $user = User::create([
    //             'name'  => $request->name,
    //             'email' => $request->email,
    //             'password' => bcrypt('12345'),
    //             'role'  => $request->role,
    //             'foto'  => $fotoPath,
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data berhasil ditambahkan',
    //             'data'    => $user
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => "Terjadi kesalahan saat menyimpan data"
    //         ], 500);
    //     }
    // }

    // public function show($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);

    //         return response()->json($user);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'Data tidak ditemukan'
    //         ], 404);
    //     }
    // }

    // public function deactivate($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);
    //         $user->status = false;
    //         $user->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data berhasil dinonaktifkan'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal menonaktifkan data'
    //         ], 500);
    //     }
    // }

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

    // public function destroy($id)
    // {
    //     try {
    //         $user = User::findOrFail($id);

    //         if ($user->foto && Storage::disk('public')->exists($user->foto)) {
    //             Storage::disk('public')->delete($user->foto);
    //         }

    //         $user->delete();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data berhasil dihapus'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal menghapus data'
    //         ], 500);
    //     }
    // }
}
