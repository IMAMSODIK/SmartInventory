<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginCheck(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'email' => 'required|string|email',
            'password' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $r->email)->first();

        if (!$user->status) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak aktif'
            ], 401);
        }

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ], 401);
        }

        if (password_verify($r->password, $user->password)) {
            Auth::login($user);
            $r->session()->regenerate();

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'redirect' => redirect()->intended('/dashboard')->getTargetUrl()
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function registerKurir(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'phone' => 'required|unique:users,phone',
            'vehicle' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => 'kurir',
            'password' => bcrypt('12345678')
        ]);

        return response()->json([
            'message' => 'Pendaftaran kurir berhasil'
        ]);
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|numeric',
                'password' => 'required|min:5|confirmed',
                'role' => 'required|in:pembeli,kurir,pedagang'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'status' => false
            ]);

            return response()->json([
                'message' => 'Registrasi berhasil sebagai ' . $user->role
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerate();

        return redirect('/login');
    }
}
