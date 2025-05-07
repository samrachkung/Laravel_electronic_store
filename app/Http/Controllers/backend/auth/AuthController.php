<?php
namespace App\Http\Controllers\backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    // public function getloginpage()
    // {
    //     return view('backend.auth.login');
    // }

    // public function postlogin(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $remember = $request->boolean('remember');

    //     // Attempt to authenticate the user with "active" status
    //     if (Auth::attempt([
    //         'email' => $credentials['email'],
    //         'password' => $credentials['password'],
    //         'active' => 1,
    //     ], $remember)) {

    //         $user = Auth::user();

    //         // // Check if the user has the required 'admin' role
    //         // if (!$user->hasRole('admin')) {
    //         //     Auth::logout();
    //         //     return back()->withErrors([
    //         //         'email' => 'You do not have admin privileges.',
    //         //     ])->onlyInput('email');
    //         // }

    //         // Regenerate session
    //         $request->session()->regenerate();

    //         // Set preferred locale
    //         if ($user->language) {
    //             app()->setLocale($user->language);
    //         }

    //         return redirect()->route('backend.dashboard.index')->with('success', 'Login successful!');
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ])->onlyInput('email');
    // }

    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('admin.login');
    // }

    // public function getregisterpage()
    // {
    //     return view('backend.auth.register');
    // }

    // public function postregister(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'language' => 'required|string|max:5',
    //         'terms' => 'accepted'
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'language' => $request->language,
    //         'active' => true,
    //     ]);

    //     // Assign the user the 'admin' role (must exist in roles table)
    //     $user->roles()->attach(\App\Models\Role::where('name', 'admin')->first()->id);

    //     Alert::success('Success', 'Registration successful! Please login.');
    //     return redirect()->route('admin.login');
    // }
}
