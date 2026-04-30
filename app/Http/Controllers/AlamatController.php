<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Http\Requests\StoreAlamatRequest;
use App\Http\Requests\UpdateAlamatRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlamatController extends Controller
{
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'label' => 'nullable|string|max:50',
                'full_address' => 'required|string',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            $user = auth()->user();

            DB::beginTransaction();

            // kalau mau set default otomatis
            $isDefault = !Alamat::where('user_id', $user->id)->exists();

            $alamat = Alamat::create([
                'user_id' => $user->id,
                'label' => $validated['label'],
                'full_address' => $validated['full_address'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'is_default' => $isDefault
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Alamat berhasil disimpan',
                'data' => $alamat
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan alamat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function list()
    {
        $alamats = Alamat::where('user_id', auth()->id())
            ->orderByDesc('is_default')
            ->get();

        return response()->json([
            'data' => $alamats
        ]);
    }

    public function setDefault($id)
    {
        try {
            $userId = auth()->id();

            DB::beginTransaction();

            // reset semua
            Alamat::where('user_id', $userId)
                ->update(['is_default' => false]);

            // set yang dipilih
            Alamat::where('id', $id)
                ->where('user_id', $userId)
                ->update(['is_default' => true]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Alamat default berhasil diubah'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $alamat = Alamat::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $wasDefault = $alamat->is_default;

            $alamat->delete();

            // kalau yang dihapus adalah default → set default baru
            if ($wasDefault) {
                $newDefault = Alamat::where('user_id', auth()->id())->first();

                if ($newDefault) {
                    $newDefault->update(['is_default' => true]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Alamat berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
}
