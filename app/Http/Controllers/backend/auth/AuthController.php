<?php

namespace App\Http\Controllers\backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
;


class AuthController extends Controller
{
    public function getloginpage()
    {
        return view('backend.auth.login');


    }

    public function postlogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'sometimes|boolean'
        ]);

        if (
            Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'active' => '1' // Only allow active users
            ], $credentials['remember'] ?? false)
        ) {
            $request->session()->regenerate();

            // Set user's language preference
            if (Auth::user()->language) {
                app()->setLocale(Auth::user()->language);
            }

            return redirect('/dashboard')
                ->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }


    public function getregisterpage()
    {
        return view('backend.auth.register');
    }

    public function postregister(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'language' => 'required|string|max:5',
            'terms' => 'accepted'
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'language' => $request->language,
        ]);

        // Redirect with success message
        Alert::success('Success', 'Registration successful! Please login.');
        return redirect()->route('login');
    }
}
