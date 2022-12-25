<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function view(){
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {   
        $request->validate([
            'email'=>'required|string',
            'password'=>'required|string'
        ]);
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            return redirect()->intended('dashboard');
        }
    
        return back()->with([
            'loginError' => 'email atau Password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
