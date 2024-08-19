@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<div class="main-content">
    
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
    <h1>Your Shopping Cart</h1>
    @if(!$items)
        <div class="alert alert-info">Your cart is empty.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td><a href="{{route('product.show',$item->product->id)}}">{{ $item->product->name }}</a></td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->product->price }}</td>
                        <td>${{ $item->quantity * $item->product->price }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-right"><strong>Total: ${{ $items->sum(function($item) { return $item->quantity * $item->product->price; }) }}</strong></p>
        <a href="{{ route('order.place') }}" class="btn btn-success">Proceed to Order</a>
    @endif
</div>
@endsection
