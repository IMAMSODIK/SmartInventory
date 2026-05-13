<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {

            $pageTitle = 'Dashboard';
            $user = auth()->user();
            $today = Carbon::today();

            /*
        |--------------------------------------------------
        | ADMIN & PENJUAL SHARED LOGIC
        |--------------------------------------------------
        */
            if ($user->role === 'admin' || $user->role === 'pedagang') {

                // BASE ORDER QUERY
                $baseOrderQuery = Order::query();

                // 🔥 FILTER KHUSUS PENJUAL
                if ($user->role === 'pedagang') {

                    if (!$user->profileUsaha) {
                        return back()->with('error', 'Profile usaha belum dibuat');
                    }

                    $baseOrderQuery->whereHas('orderItem.produk', function ($q) use ($user) {
                        $q->where('profile_usaha_id', $user->profileUsaha->id);
                    });
                }

                /*
            |--------------------------------------------------
            | USER STATS (HANYA ADMIN)
            |--------------------------------------------------
            */
                $userStats = [];

                if ($user->role === 'admin') {
                    $userStats = [
                        'total_user' => User::where('role', '!=', 'admin')->count(),
                        'total_pedagang' => User::where('role', 'pedagang')->count(),
                        'total_pembeli' => User::where('role', 'pembeli')->count(),
                        'total_kurir' => User::where('role', 'kurir')->count(),
                    ];
                }

                /*
            |--------------------------------------------------
            | ORDER OVERVIEW
            |--------------------------------------------------
            */
                $orderOverview = [
                    'today' => [
                        'total' => (clone $baseOrderQuery)->whereDate('created_at', $today)->count(),
                        'pending' => (clone $baseOrderQuery)->whereDate('created_at', $today)->where('status', 'pending')->count(),
                        'processing' => (clone $baseOrderQuery)->whereDate('created_at', $today)->whereIn('status', ['paid', 'processing'])->count(),
                        'shipping' => (clone $baseOrderQuery)->whereDate('created_at', $today)->where('status', 'shipping')->count(),
                        'delivered' => (clone $baseOrderQuery)->whereDate('created_at', $today)->where('status', 'selesai')->count(),
                    ],
                    'all' => [
                        'total' => (clone $baseOrderQuery)->count(),
                        'pending' => (clone $baseOrderQuery)->where('status', 'pending')->count(),
                        'processing' => (clone $baseOrderQuery)->whereIn('status', ['paid', 'processing'])->count(),
                        'shipping' => (clone $baseOrderQuery)->where('status', 'shipping')->count(),
                        'delivered' => (clone $baseOrderQuery)->where('status', 'selesai')->count(),
                    ],
                ];

                /*
            |--------------------------------------------------
            | REVENUE
            |--------------------------------------------------
            */
                $revenueQuery = (clone $baseOrderQuery)->where('status', 'selesai');

                $revenue = [
                    'revenue_today' => (clone $revenueQuery)
                        ->whereDate('created_at', $today)
                        ->sum('total'),

                    'revenue_all' => (clone $revenueQuery)->sum('total'),
                ];

                return view('dashboard.index', array_merge([
                    'pageTitle' => $pageTitle,
                    'orderOverview' => $orderOverview,
                    'revenue' => $revenue,
                ], $userStats));
            }

            /*
        |--------------------------------------------------
        | KURIR (TIDAK DIUBAH)
        |--------------------------------------------------
        */
            if ($user->role === 'kurir') {

                $driver = $user->driver;

                $totalOrderSelesai = 0;
                $totalPendapatan = 0;

                if ($driver) {

                    $totalOrderSelesai = OrderItem::where('driver_id', $driver->id)
                        ->where('delivery_status', 'delivered')
                        ->distinct('order_id')
                        ->count('order_id');

                    $orders = Order::whereHas('orderItem', function ($q) use ($driver) {
                        $q->where('driver_id', $driver->id)
                            ->where('delivery_status', 'delivered');
                    })->get();

                    foreach ($orders as $order) {

                        $driverCount = OrderItem::where('order_id', $order->id)
                            ->distinct('driver_id')
                            ->count('driver_id');

                        $totalPendapatan += $order->shipping_cost / max($driverCount, 1);
                    }
                }

                return view('dashboard.index', compact(
                    'pageTitle',
                    'totalOrderSelesai',
                    'totalPendapatan'
                ));
            }

            /*
        |--------------------------------------------------
        | PEMBELI (TIDAK DIUBAH)
        |--------------------------------------------------
        */
            if ($user->role === 'pembeli') {

                $activeOrders = Order::with([
                    'alamat',
                    'orderItem.produk.fotoProduk'
                ])
                    ->where('buyer_id', $user->id)
                    ->whereNotIn('status', ['selesai', 'cancelled', 'expired'])
                    ->latest()
                    ->get();

                $historyOrders = Order::with([
                    'alamat',
                    'orderItem.produk.fotoProduk'
                ])
                    ->where('buyer_id', $user->id)
                    ->whereIn('status', ['selesai', 'cancelled', 'expired'])
                    ->latest()
                    ->get();

                return view('dashboard.index', compact(
                    'pageTitle',
                    'activeOrders',
                    'historyOrders'
                ));
            }

            /*
        |--------------------------------------------------
        | DEFAULT
        |--------------------------------------------------
        */
            return view('dashboard.index', compact('pageTitle'));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }
}
