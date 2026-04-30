<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\FotoProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index()
    {
        try {
            $kategoriMenus = DB::table('kategoris')->where('status', true)->get();

            return view('produk.index', [
                'pageTitle' => 'Daftar Produk',
                'kategoriMenus' => $kategoriMenus
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat halaman: ' . $e->getMessage());
        }
    }

    public function data(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user->role == 'admin') {

                $query = Produk::with(['fotoProduk', 'kategori'])
                    ->where('status', 1);

                $checkProfile = true;
            } else if ($user->role == 'pedagang') {

                if (!$user->profileUsaha) {
                    return response()->json([
                        'check_profile' => false,
                        'message' => 'Profile usaha tidak ditemukan'
                    ]);
                }

                $query = Produk::with(['fotoProduk', 'kategori'])
                    ->where('profile_usaha_id', $user->profileUsaha->id)
                    ->where('status', 1);

                $checkProfile = true;
            }

            // 🔥 role lain (optional)
            else {
                return response()->json([
                    'check_profile' => false,
                    'message' => 'Role tidak diizinkan'
                ], 403);
            }

            // 🔍 filter kategori (tetap sama)
            if ($request->filled('kategori') && is_array($request->kategori)) {
                $query->whereIn('kategori_id', $request->kategori);
            }

            // 🔍 search (tetap sama)
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $produk = $query->get();

            return response()->json([
                'check_profile' => $checkProfile,
                'data' => $produk
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function loadData(Request $request)
    {
        try {
            $query = Produk::with(['fotoProduk', 'kategori'])
                ->where('status', $request->status ?? 1)
                ->where('is_approved', 1)
                ->where('status', 1);

            if ($request->filled('kategori') && $request->kategori != '0') {
                $menu = $query->where('kategori_id', $request->kategori)->get();
            } else {
                $menu = $query->get();
            }

            return response()->json([
                'data' => $menu
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data'
            ], 500);
        }
    }

    function dataTable(Request $request)
    {
        try {
            $query = Produk::with('kategori')->where('status', 0);

            $menu = $query->get();

            return response()->json([
                'data' => $menu
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'foto_produk' => 'required',
            'foto_produk.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'price.required' => 'Harga wajib diisi',
            'foto_produk.required' => 'Minimal 1 foto wajib diupload',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $user = auth()->user();

            $produk = Produk::create([
                'kategori_id' => $request->kategori_id,
                'profile_usaha_id' => $user->profileUsaha->id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock ?? 0,
                'unit' => $request->unit,
                'is_approved' => false,
            ]);

            if ($request->hasFile('foto_produk')) {
                foreach ($request->file('foto_produk') as $file) {
                    $path = $file->store('foto_produk', 'public');

                    FotoProduk::create([
                        'produk_id' => $produk->id,
                        'image' => $path
                    ]);
                }
            }

            DB::commit();

            $produk->load(['fotoProduk', 'kategori']);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan',
                'data' => $produk
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $produk = Produk::with(['fotoProduk', 'kategori'])->findOrFail($id);

            return response()->json($produk);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_name' => 'required|string|max:255',
            'edit_kategori_id' => 'required|exists:kategoris,id',
            'edit_price' => 'required|numeric',
            'edit_stock' => 'nullable|integer|min:0',
            'edit_unit' => 'nullable|string|max:50',
            'edit_foto_produk.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $produk = Produk::findOrFail($request->id);

            $produk->update([
                'name' => $request->edit_name,
                'kategori_id' => $request->edit_kategori_id,
                'price' => $request->edit_price,
                'stock' => $request->edit_stock ?? 0,
                'unit' => $request->edit_unit,
                'description' => $request->edit_description,
            ]);

            if ($request->hasFile('edit_foto_produk')) {

                foreach ($produk->fotoProduk as $foto) {
                    Storage::disk('public')->delete($foto->image);
                }

                $produk->fotoProduk()->delete();

                foreach ($request->file('edit_foto_produk') as $file) {
                    $path = $file->store('foto_produk', 'public');

                    FotoProduk::create([
                        'produk_id' => $produk->id,
                        'image' => $path
                    ]);
                }
            }

            DB::commit();

            $produk->load(['fotoProduk', 'kategori']);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diupdate',
                'data' => $produk
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Gagal update: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deactivate($id)
    {
        try {
            $menu = Produk::findOrFail($id);
            $menu->status = false;
            $menu->save();

            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus menu' . $e->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $menus = Produk::findOrFail($id);
            $menus->status = true;
            $menus->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dikembalikan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengembalikan data'
            ], 500);
        }
    }

    // public function toggleReady(Request $request)
    // {
    //     try {
    //         $menu = Menu::findOrFail($request->id);

    //         $menu->is_ready = !$menu->is_ready;
    //         $menu->save();

    //         return response()->json([
    //             'success' => true,
    //             'is_ready' => $menu->is_ready,
    //             'message' => 'Status berhasil diubah'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal update status'
    //         ], 500);
    //     }
    // }

    public function toggleApprove(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:produks,id'
            ]);

            $produk = Produk::findOrFail($request->id);

            $produk->is_approved = !$produk->is_approved;
            $produk->save();

            return response()->json([
                'success' => true,
                'message' => $produk->is_approved ? 'Produk di-approve' : 'Produk di-suspend',
                'data' => [
                    'id' => $produk->id,
                    'is_approved' => $produk->is_approved
                ]
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Gagal update status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
