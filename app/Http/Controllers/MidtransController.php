<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }
        $order = Order::where('order_id', $request->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $order->payment_type = $request->payment_type;
        $order->transaction_id = $request->transaction_id;
        $order->fraud_status = $request->fraud_status;

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;
        
        if ($transactionStatus == 'capture') {

            if ($fraudStatus == 'challenge') {
                $order->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $order->status = 'paid';
            }
        } elseif ($transactionStatus == 'settlement') {
            $order->status = 'paid';
        } elseif ($transactionStatus == 'pending') {
            $order->status = 'pending';
        } elseif ($transactionStatus == 'deny') {
            $order->status = 'deny';
        } elseif ($transactionStatus == 'expire') {
            $order->status = 'expired';
        } elseif ($transactionStatus == 'cancel') {
            $order->status = 'cancelled';
        }

        $order->save();

        return response()->json(['success' => true]);
    }
}
