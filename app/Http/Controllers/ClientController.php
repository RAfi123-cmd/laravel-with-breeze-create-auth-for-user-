<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function ClientLogin()
    {
        return view('client.client_login');
    }
    public function ClientRegister()
    {
        return view('client.client_register');
    }

    public function ClientRegisterSubmit(Request $request){
        $request->validate([
            'name' => ['required','string','max:200'],
            'email' => ['required','string','unique:clients']
        ]);

        Client::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'client',
            'status' => '0',
        ]);

        $notification = array(
            'message' => 'Client Register Succesfully',
            'alert-type' => 'success'
        );
        return redirect()->route('client.login')->with($notification);
    }

    public function ClientLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];
        if (Auth::guard('client')->attempt($data)) {
            return redirect()->route('client.dashboard')->with('success', 'Login Successfully');
        } else {
            return redirect()->route('client.login')->with('error', 'Invalid Creadentials');
        }
    }

    public function ClientDashboard(){
        return view('client.index');
    }
    public function ClientLogout()
    {
        Auth::guard('client')->logout();
        return redirect()->route('client.login')->with('success', 'Logout Success');
    }
}
