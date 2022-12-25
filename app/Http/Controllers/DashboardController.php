<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function view(){
        $user = Auth::user();
        return view('home.dashboard', compact('user'));
    }
}
