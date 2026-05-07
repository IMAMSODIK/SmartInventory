<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

            $data = [];

            if ($user->role === 'admin') {
                $today = Carbon::today();
                $data = [
                    //user
                    'total_user' => \App\Models\User::where('role', '!=', 'admin')->count(),
                    'total_pedagang' => \App\Models\User::where('role', 'pedagang')->count(),
                    'total_pembeli' => \App\Models\User::where('role', 'pembeli')->count(),
                    'total_kurir' => \App\Models\User::where('role', 'kurir')->count(),
                ];

                $orderOverview = [
                    'today' => [
                        'total' => Order::whereDate('created_at', $today)->count(),
                        'pending' => Order::whereDate('created_at', $today)->where('status', 'pending')->count(),
                        'processing' => Order::whereDate('created_at', $today)->whereIn('status', ['paid', 'processing'])->count(),
                        'shipping' => Order::whereDate('created_at', $today)->where('status', 'shipping')->count(),
                        'delivered' => Order::whereDate('created_at', $today)->where('status', 'delivered')->count(),
                    ],
                    'all' => [
                        'total' => Order::count(),
                        'pending' => Order::where('status', 'pending')->count(),
                        'processing' => Order::whereIn('status', ['paid', 'processing'])->count(),
                        'shipping' => Order::where('status', 'shipping')->count(),
                        'delivered' => Order::where('status', 'delivered')->count(),
                    ],
                ];
                $revenue = [
                    'revenue_today' => Order::where('status', 'delivered')
                        ->whereDate('created_at', $today)
                        ->sum('total'),
                    'revenue_all' => Order::where('status', 'delivered')
                        ->sum('total')
                ];
                return view('dashboard.index', compact('pageTitle', 'data', 'orderOverview', 'revenue'));
            }else{
                return view('dashboard.index', compact('pageTitle'));
            }

            
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
