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
            $data = [
                'pageTitle' => "Profile Driver",
                'data' => User::where('id', Auth::id())->with('driver')->first()
            ];

            return view('profile.profile_driver', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
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
                ], 404);
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

            $orderItem = OrderItem::with(['order', 'order.alamat', 'order.buyer'])
                ->where('driver_id', $driver->id)
                ->where('delivery_status', 'accepted')
                ->latest()
                ->first();

            if (!$orderItem) {
                return response()->json([
                    'status' => false
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => $orderItem
            ]);
        } catch (\Exception $e) {
            return response()->json([
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

    public function completeOrder($orderId)
    {
        DB::beginTransaction();

        try {

            $driver = auth()->user()->driver;

            OrderItem::where('order_id', $orderId)
                ->where('driver_id', $driver->id)
                ->update([
                    'delivery_status' => 'delivered'
                ]);

            // 🔥 cek semua item selesai
            $allDone = OrderItem::where('order_id', $orderId)
                ->where('delivery_status', '!=', 'delivered')
                ->count();

            if ($allDone == 0) {
                Order::where('id', $orderId)->update([
                    'status' => 'delivered'
                ]);
            }

            // 🔥 driver free lagi
            $driver->update([
                'is_available' => true
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Order selesai'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menyelesaikan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
