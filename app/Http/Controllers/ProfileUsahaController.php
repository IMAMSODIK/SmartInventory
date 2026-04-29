<?php

namespace App\Http\Controllers;

use App\Models\ProfileUsaha;
use App\Http\Requests\StoreProfileUsahaRequest;
use App\Http\Requests\UpdateProfileUsahaRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileUsahaController extends Controller
{
    public function index()
    {
        try {
            $data = [
                'pageTitle' => "Profile Usaha",
                'data' => User::where('id', Auth::id())->with('profileUsaha')->first()
            ];

            return view('profile.profile_usaha', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $user = auth()->user();
        $profileUsaha = $user->profileUsaha;
        $path = $profileUsaha->store_photo ?? null;

        if ($request->hasFile('foto')) {
            if ($profileUsaha && $profileUsaha->store_photo) {
                Storage::disk('public')->delete($profileUsaha->store_photo);
            }
            $path = $request->file('foto')->store('profile_usaha', 'public');
        }

        if ($profileUsaha) {

            $profileUsaha->update([
                'store_name' => $request->name,
                'description' => $request->deskripsi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'store_photo' => $path,
            ]);
        } else {
            ProfileUsaha::create([
                'user_id' => $user->id,
                'store_name' => $request->name,
                'description' => $request->deskripsi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'store_photo' => $path,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully'
        ]);
    }
}
