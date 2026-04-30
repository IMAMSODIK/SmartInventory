<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        try {
            $data = [
                'kategori' => Kategori::with('produk')->get(),
            ];
            return view('marketplace', $data);
        } catch (\Exception $e) {
            return view('welcome', ['kategori' => []]);
        }
    }
}
