<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;

class AuthController extends Controller
{
    public function show(){
        return Inertia::render('AdminAuth/Login');
    }

    public function store(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => true])){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login')->with('error', 'Invalid credentials !');
    }

    public function logout(){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }
}
