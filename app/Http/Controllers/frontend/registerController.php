<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Make sure to import the User model

class registerController extends Controller
{
    public function register()
    {

        return view('frontend.register.register');

    }

    public function registerUser(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto-login the user
        Auth::login($user);

        return response()->json(['success' => true, 'message' => 'Registration successful!']);
    }
}
