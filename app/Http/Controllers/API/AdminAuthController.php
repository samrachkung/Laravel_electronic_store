<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show admin login page (for web)
     */
    public function getloginpage()
    {
        return view('backend.auth.login');
    }

    /**
     * Handle web admin login
     */
    public function postlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->put('admin_session', true); // Explicit session set
            return redirect()->route('admin.dashboard')
                ->with('success', 'Login successful!');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Handle API admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::guard('admin-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin-api')->factory()->getTTL() * 60,
            'admin' => auth('admin-api')->user(),
            'redirect_url' => route('admin.dashboard')
        ]);
    }

    /**
     * Get authenticated admin (API)
     */
    public function me()
    {
        return response()->json(auth('admin-api')->user());
    }

    /**
     * Logout admin (API)
     */
    public function logout()
    {
        auth('admin-api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
