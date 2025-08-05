<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,name',
            'password' => 'required|min:6|exists:users,password'
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Login successful');
    }
}
