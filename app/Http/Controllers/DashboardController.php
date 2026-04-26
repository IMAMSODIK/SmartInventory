<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        try {
            $pageTitle = 'Dashboard';

            return view('dashboard.index', compact('pageTitle'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
