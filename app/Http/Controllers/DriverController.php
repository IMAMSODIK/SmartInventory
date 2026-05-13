<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function index()
    {
        try {

            $user = User::with('driver')
                ->where('id', Auth::id())
                ->first();

            $driverId = $user->driver->id ?? null;
            $rating = DB::table('rating_drivers')
                ->where('driver_id', $driverId)
                ->avg('rating');
            $totalReview = DB::table('rating_drivers')
                ->where('driver_id', $driverId)
                ->count();
            $totalDelivery = DB::table('order_items')
                ->where('driver_id', $driverId)
                ->where('delivery_status', 'delivered')
                ->count();

            $data = [
                'pageTitle' => "Profile Driver",
                'data' => $user,
                'rating' => round($rating ?? 0, 1),
                'totalReview' => $totalReview,
                'totalDelivery' => $totalDelivery,

            ];

            return view('profile.profile_driver', $data);
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|string|max:255',
            'plat_kendaraan' => 'nullable|string|max:10|unique:drivers,plate_number,' . optional(auth()->user()->driver)->id
        ]);

        try {
            $user = auth()->user();

            $driver = $user->driver;

            if ($driver) {

                $driver->update([
                    'vehicle_type' => $request->jenis_kendaraan,
                    'plate_number' => $request->plat_kendaraan,
                ]);

                $message = 'Profile driver berhasil diperbarui';
            } else {
                $driver = Driver::create([
                    'user_id' => $user->id,
                    'vehicle_type' => $request->jenis_kendaraan,
                    'plate_number' => $request->plat_kendaraan,
                    'is_online' => false,
                    'is_available' => true,
                    'latitude' => null,
                    'longitude' => null,
                ]);

                $message = 'Profile driver berhasil dibuat';
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $driver
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan profile driver',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Request $request)
    {
        try {

            $request->validate([
                'is_online' => 'required|boolean'
            ]);

            $user = auth()->user();

            $driver = $user->driver;

            if (!$driver) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data driver tidak ditemukan'
                ]);
            }

            if (!$driver->status_approval) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data driver belum di approve admin'
                ]);
            }

            $driver->update([
                'is_online' => $request->is_online,
                'is_available' => $request->is_online
            ]);

            return response()->json([
                'success' => true,
                'message' => $request->is_online ? 'Driver ONLINE' : 'Driver OFFLINE'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getStatus()
    {
        $driver = auth()->user()->driver;

        return response()->json([
            'is_online' => $driver?->is_online ?? 0
        ]);
    }

    public function updateLocation(Request $request)
    {
        try {
            $request->validate([
                'lat' => 'required|numeric|between:-90,90',
                'lng' => 'required|numeric|between:-180,180',
            ]);

            $user = auth()->user();

            $driver = $user->driver;

            if (!$driver) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data driver tidak ditemukan'
                ], 404);
            }
            if (!$driver->is_online) {
                return response()->json([
                    'success' => false,
                    'message' => 'Driver sedang offline'
                ], 403);
            }

            if ($driver->latitude && $driver->longitude) {
                $diff = abs($driver->latitude - $request->lat) + abs($driver->longitude - $request->lng);

                if ($diff < 0.0001) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Lokasi tidak berubah signifikan'
                    ]);
                }
            } else {
                $driver->update([
                    'latitude' => $request->lat,
                    'longitude' => $request->lng,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Lokasi berhasil diperbarui'
                ]);
            }
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal update lokasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getIncomingOrder()
    {
        try {

            $driver = auth()->user()->driver;

            if (!$driver) {
                return response()->json([
                    'status' => false,
                    'message' => 'Driver tidak ditemukan'
                ]);
            }

            $orders = OrderItem::with([
                'order',
                'order.alamat',
                'order.buyer',
                'produk.profileUsaha.user'
            ])
                ->where('driver_id', $driver->id)
                ->whereIn('delivery_status', [
                    'pending',
                    'picked',
                    'on_delivery',
                    'delivered',
                    'assigned',
                ])
                ->latest()
                ->get()
                ->groupBy('order_id');

            return response()->json([
                'status' => $orders->isNotEmpty(),
                'data' => $orders
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Gagal ambil order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function shippingOrder($orderId)
    {
        DB::beginTransaction();

        try {

            $driver = auth()->user()->driver;

            OrderItem::where('order_id', $orderId)
                ->where('driver_id', $driver->id)
                ->update([
                    'delivery_status' => 'shipping'
                ]);

            DB::commit();

            return response()->json([
                'message' => 'Order sedang dikirim'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Gagal proses kirim',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function acceptOrder($id)
    {
        try {

            OrderItem::where('order_id', $id)
                ->update([
                    'delivery_status' => 'picked'
                ]);

            return response()->json([
                'status' => true,
                'message' => 'Order berhasil diterima'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function startDelivery($id)
    {
        try {

            OrderItem::where('order_id', $id)
                ->update([
                    'delivery_status' => 'on_delivery'
                ]);

            return response()->json([
                'status' => true,
                'message' => 'Pesanan sedang diantar'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function completeOrder($id)
    {
        try {
            OrderItem::where('order_id', $id)
                ->update([
                    'delivery_status' => 'delivered'
                ]);

            Order::find($id)->update([
                'status' => 'delivered'
            ]);

            $driver = auth()->user()->driver;
            $driver->update([
                'is_available' => true
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Pesanan selesai'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
