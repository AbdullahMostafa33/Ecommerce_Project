@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="checkout-container">
    <h1>Checkout</h1>

    <div class="checkout-content">
        <!-- Cart Items Section -->
        <div class="cart-items">
            <h2>Your Order</h2>
            @if($orderItems)
                <ul class="cart-item-list">
                    @foreach($orderItems as $item)
                        <li class="cart-item">
                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="cart-item-image">
                            <div class="cart-item-details">
                                <h3 class="cart-item-name">{{ $item->product->name }}</h3>
                                <p class="cart-item-price">${{ $item->product->price }}</p>
                                <p class="cart-item-quantity">Quantity: {{ $item->quantity }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="cart-total">
                    <h3>Total: ${{ $orderItems->sum(fn($item) => $item->product->price * $item->quantity) }}</h3>
                </div>
            @else
                <p>Your cart is empty.</p>
            @endif
        </div>

        <!-- Shipping Details Section -->
        <div class="shipping-details">
            <h2>Shipping Details</h2>
            <form action="/myfatoorah"  class="checkout-form">                
                    <input type="text" value="{{$id}}" name="id" hidden>
               
              <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Check Out</button>
            </form>
        </div>
    </div>
</div>
<style>
    /* Checkout Container */
.checkout-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 40px;
    color: #333;
}

/* Checkout Content */
.checkout-content {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.cart-items, .shipping-details {
    flex: 1;
    min-width: 300px;
}

.cart-items h2, .shipping-details h2 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: #333;
}

.cart-item-list {
    list-style: none;
    padding: 0;
}

.cart-item {
    display: flex;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.cart-item-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin-right: 15px;
}

.cart-item-details {
    flex: 1;
}

.cart-item-name {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.cart-item-price {
    font-size: 1rem;
    color: #007bff;
}

.cart-item-quantity {
    font-size: 0.9rem;
    color: #666;
}

/* Cart Total */
.cart-total {
    margin-top: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f8f9fa;
}

.cart-total h3 {
    font-size: 1.25rem;
    color: #333;
}

/* Checkout Form */
.checkout-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-size: 0.9rem;
    margin-bottom: 5px;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.payment-info {
    margin-top: 30px;
}

.payment-info h2 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: #333;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
    border-radius: 4px;
    text-align: center;
}

.btn-primary:hover {
    background-color: #0056b3;
}

</style>
@endsection
