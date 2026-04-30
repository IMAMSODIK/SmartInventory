<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileUsahaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::get('/marketplace', [MainController::class, 'index']);
Route::get('/daftar-produk/load-data', [ProdukController::class, 'loadData']);

Route::post('/checkout', [OrderController::class, 'checkout']);
Route::get('/order/status/{orderId}', [OrderController::class, 'checkStatus']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/user/detail/{id}', [UserController::class, 'detail']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/data', [UserController::class, 'data']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users/store', [UserController::class, 'store']);
    Route::post('/users/update/{id}', [UserController::class, 'update']);
    Route::post('/users/delete/{id}', [UserController::class, 'deactivate']);
    Route::post('/users/restore/{id}', [UserController::class, 'restore']);
    Route::delete('/users/destroy/{id}', [UserController::class, 'destroy']);

    Route::get('/daftar-produk', [ProdukController::class, 'index']);
    Route::get('/daftar-produk/data', [ProdukController::class, 'data']);
    Route::get('/daftar-produk/data-table', [ProdukController::class, 'dataTable']);
    Route::post('/daftar-produk/toggle-ready', [ProdukController::class, 'toggleReady']);
    Route::get('/daftar-produk/{id}', [ProdukController::class, 'show']);
    Route::post('/daftar-produk/store', [ProdukController::class, 'store']);
    Route::post('/daftar-produk/update', [ProdukController::class, 'update']);
    Route::post('/daftar-produk/delete/{id}', [ProdukController::class, 'deactivate']);
    Route::post('/daftar-produk/restore/{id}', [ProdukController::class, 'restore']);
    Route::delete('/daftar-produk/destroy/{id}', [ProdukController::class, 'destroy']);

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('password.update');

    Route::get('/profile-usaha', [ProfileUsahaController::class, 'index']);
    Route::post('/profile-usaha', [ProfileUsahaController::class, 'update']);

    Route::post('/alamat/store', [AlamatController::class, 'store']);
    Route::get('/alamat/list', [AlamatController::class, 'list']);
    Route::post('/alamat/set-default/{id}', [AlamatController::class, 'setDefault']);
    Route::delete('/alamat/delete/{id}', [AlamatController::class, 'delete']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginCheck']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::fallback(function () {
    return redirect('/coming-soon');
});

Route::get('/coming-soon', function () {
    return view('pages.coming_soon');
});

Route::get('/', function(){
    return view('welcome');
});