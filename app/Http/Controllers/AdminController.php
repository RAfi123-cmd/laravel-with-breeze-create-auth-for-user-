<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminLogin()
    {
        return view('admin.login');
    }
    // end method

    public function AdminDashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function AdminLoginSubmit(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];
        if (Auth::guard('admin')-> attempt($data)) {
            return redirect()->route('admin.dashboard')->with('succes','Login Successfully');
        }else{
            return redirect()->route('admin.login')->with('error','Invalid Creadentials');
        }
    }

    public function AdminLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Logout Success');
    }
}
