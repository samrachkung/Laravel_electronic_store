<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class loginController extends Controller
{
    public function login()
    {
        return view('frontend.login.login');
    }

    public function authenticate(Request $request)
    {
        // Validate inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to authenticate user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Prevent session fixation attacks
            return response()->json(['success' => true, 'message' => 'Login successful!']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid email or password!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }



    protected function authenticated(Request $request, $user)
    {
        // Get session cart
        $sessionCart = session()->get('cart', []);

        foreach ($sessionCart as $item) {
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $item['id'])
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $item['quantity'];
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity']
                ]);
            }
        }

        // Clear session cart
        session()->forget('cart');
    }

}
