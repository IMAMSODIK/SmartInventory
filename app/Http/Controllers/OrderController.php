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
}
