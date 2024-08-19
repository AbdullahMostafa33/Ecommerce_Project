<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function checkUser($order){
        if ($order && $order->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');                 
        }
    }
    // Show checkout form
    public function checkout(Order $order)
    {
   
        $orderItems = $order ? $order->orderItems : [];
$id=$order->id;
        return view('orders.checkout', compact('orderItems','id'));
    }

    // Process the order
    public function placeOrder()
    {
      
        $cart = Auth::user()->carts()->latest()->first();
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $cart->cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            }),
            'status' => 'unpaid',
        ]);

        foreach ($cart->cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        $cart->delete(); // Clear the cart

       return redirect()->route('checkout',$order)->with('success', 'Order placed successfully.');
    }

    // Show user's orders
    public function index()
    {
        $orders = Auth::user()->orders->where('status_move','!=', 'cancelled');
        return view('orders.index', compact('orders'));
    }

    public function showInvoice(Order $order){

       $this-> checkUser($order);
        
       return view('orders.invoice', compact('order'));
    }

    public function cancel(Request $request){
        $order=Order::findOrfail($request->id);
        $order->status_move= 'cancelled';
        $order->save();
        return back()->with('success', 'Order cancelled successfully.');

    }
}
