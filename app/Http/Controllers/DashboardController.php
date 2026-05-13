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

            $isAdmin = $user->role === 'admin';
            $profileId = $user->profileUsaha?->id;

            /*
        |--------------------------------------------------
        | BASE ORDER QUERY (ADMIN / PENJUAL)
        |--------------------------------------------------
        */
            $orderQuery = Order::query();

            if ($user->role === 'pedagang') {

                if (!$profileId) {
                    return back()->with('error', 'Profile usaha belum dibuat');
                }

                $orderQuery->whereHas('orderItem.produk', function ($q) use ($profileId) {
                    $q->where('profile_usaha_id', $profileId);
                });
            }

            /*
        |--------------------------------------------------
        | ADMIN / PENJUAL DASHBOARD
        |--------------------------------------------------
        */
            if ($user->role === 'admin' || $user->role === 'pedagang') {

                $userStats = $isAdmin ? [
                    'total_user' => User::where('role', '!=', 'admin')->count(),
                    'total_pedagang' => User::where('role', 'pedagang')->count(),
                    'total_pembeli' => User::where('role', 'pembeli')->count(),
                    'total_kurir' => User::where('role', 'kurir')->count(),
                ] : [];

                $orderOverview = [
                    'today' => [
                        'total' => (clone $orderQuery)->whereDate('created_at', $today)->count(),
                        'pending' => (clone $orderQuery)->whereDate('created_at', $today)->where('status', 'pending')->count(),
                        'processing' => (clone $orderQuery)->whereDate('created_at', $today)->whereIn('status', ['paid', 'processing'])->count(),
                        'shipping' => (clone $orderQuery)->whereDate('created_at', $today)->where('status', 'shipping')->count(),
                        'delivered' => (clone $orderQuery)->whereDate('created_at', $today)->where('status', 'selesai')->count(),
                    ],
                    'all' => [
                        'total' => (clone $orderQuery)->count(),
                        'pending' => (clone $orderQuery)->where('status', 'pending')->count(),
                        'processing' => (clone $orderQuery)->whereIn('status', ['paid', 'processing'])->count(),
                        'shipping' => (clone $orderQuery)->where('status', 'shipping')->count(),
                        'delivered' => (clone $orderQuery)->where('status', 'selesai')->count(),
                    ],
                ];

                $revenueQuery = (clone $orderQuery)->where('status', 'selesai');

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
                ], $userStats ?? []));
            }

            /*
        |--------------------------------------------------
        | KURIR DASHBOARD
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
        | PEMBELI DASHBOARD
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
            return back()->with('error', $e->getMessage());
        }
    }
}
