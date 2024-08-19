<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show the current user's cart
    public function index()
    {
        $cart = Auth::user()->carts()->latest()->first();
        $items = $cart ? $cart->cartItems : [];
        return view('cart.index', compact('items'));
    }

    // Add a product to the cart
    public function add(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $cart = Auth::user()->carts()->latest()->firstOrCreate();
        $cartItem = $cart->cartItems()->where('product_id', $product_id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->cartItems()->create([
                'product_id' => $product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    // Remove a product from the cart
    public function remove($item_id)
    {
        $cartItem = CartItem::findOrFail($item_id);
        $cartItem->delete();

        return back()->with('success', 'Product removed from cart.');
    }
}