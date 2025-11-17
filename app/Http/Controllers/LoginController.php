<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function adminLogin(Request $request){
        // return $request;
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Allow login by email or username
        $credentials = [
            filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username'
                => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials.',
        ]);
    }
}
