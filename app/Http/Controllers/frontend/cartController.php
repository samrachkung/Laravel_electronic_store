<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
class CartController extends Controller
{
    public function cart()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('frontend.login')->with('error', 'Please login to view your cart.');
        }
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
        return view('frontend.cart.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        $user = auth()->user();

        $product = DB::table('products')->where('id', $productId)->first();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        if ($user) {
            $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();
            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                Cart::create(['user_id' => $user->id, 'product_id' => $productId, 'quantity' => $quantity]);
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => asset($product->image ?: 'frontend/images/product_images/placeholder.png'),
                ];
            }
            session()->put('cart', $cart);
        }
        return response()->json(['success' => true, 'message' => 'Product added to cart!']);
    }

    public function viewCart()
    {
        $user = auth()->user();
        $cart = $user ? Cart::where('user_id', $user->id)->with('product')->get() : session()->get('cart', []);
        return response()->json(['items' => $cart]);
    }

    public function updateCart(Request $request)
    {
        $cart = Cart::find($request->id);

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart item not found.']);
        }

        // Update quantity
        $cart->quantity = $request->quantity;
        $cart->save();

        // Get the product price from the products table
        $product = Product::find($cart->product_id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        $productPrice = $product->price;

        // Calculate new total for this item
        $newTotal = $cart->quantity * $productPrice;

        // Calculate grand total (sum of all cart items)
        $grandTotal = Cart::join('products', 'carts.product_id', '=', 'products.id')
            ->selectRaw('SUM(carts.quantity * products.price) as total')
            ->first()->total;

        return response()->json([
            'success' => true,
            'newTotal' => $newTotal,
            'grandTotal' => $grandTotal
        ]);
    }

    public function removeCart(Request $request)
    {
        $productId = $request->input('id');
        $user = auth()->user();

        if (!$productId) {
            return response()->json(['success' => false, 'message' => 'Product ID is missing'], 400);
        }

        if ($user) {
            $cartItem = Cart::where('user_id', $user->id)->where('id', $productId)->first();
            if ($cartItem) {
                $cartItem->delete();
                return response()->json(['success' => true, 'message' => 'Product removed successfully']);
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
                return response()->json(['success' => true, 'message' => 'Product removed successfully']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Product not found in cart'], 404);
    }

}

