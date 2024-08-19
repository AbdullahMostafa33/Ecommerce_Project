@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
<div class="orders-container">
    <h1>My Orders</h1>

    <div class="orders-content">
        @if($orders->isNotEmpty())
            <ul class="orders-list">
                <?php $i=0;?>
                @foreach($orders as $order)
                    <li class="order-card">
                        <div class="order-header">
                            <h2>Order # {{++$i}}</h2>
                            <p class="order-date">{{ $order->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="order-status">
                            <span class="status-label">Status:</span>
                            <span class="status-value">{{ $order->status }}</span>
                        </div>
                        <div class="order-status">
                            <span class="status-label">Status movement:</span>
                            <span class="status-value">{{ $order->status_move }}</span>
                        </div>
                        <div class="order-body">
                            <ul class="order-items">
                                @foreach($order->orderItems as $item)
                                    <li class="order-item">
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="order-item-image">
                                        <div class="order-item-details">
                                            <h3 class="order-item-name">{{ $item->product->name }}</h3>
                                            <p class="order-item-quantity">Quantity: {{ $item->quantity }}</p>
                                            <p class="order-item-price">${{ $item->product->price }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="order-footer">
                            <h3 class="order-total">Total: ${{ $order->total_price }}</h3>
                            @if ($order->status!='paid')
                                <div style="display:inline-flex">
                                     <form action="/myfatoorah" style="margin-right: 2px" >                
                     <input type="text" value="{{$order->id}}" name="id" hidden>
               
           
                         <button type="submit" class="btn btn-primary">pay now</button>
                   </form>
                   <form action="{{route('order.cancel')}}" >                
                     <input type="text" value="{{$order->id}}" name="id" hidden>
               
           
                         <button type="submit" class="btn btn-primary" style="background-color: red">cancel</button>
                   </form>
                                </div>

                            @else 
                               <a class="btn btn-primary" href="{{route('invoice.show',$order->id)}}">show invoice</a>
                            @endif

                           
                        </div>
                       
                    </li>
                    <br>
                @endforeach
            </ul>
        @else
            <p>You have no orders.</p>
        @endif
    </div>
</div>

<style>
/* Orders Container */
.orders-container {
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

/* Orders Content */
.orders-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.orders-list {
    list-style: none;
    padding: 0;
}

/* Order Card */
.order-card {
    background: #f9f9f9;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* Order Header */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.order-header h2 {
    font-size: 1.5rem;
    color: #333;
}

.order-date {
    font-size: 0.9rem;
    color: #777;
}

/* Order Status */
.order-status {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.status-label {
    font-size: 1rem;
    color: #333;
    font-weight: bold;
}

.status-value {
    font-size: 1rem;
    color: #007bff;
}

/* Order Body */
.order-body {
    margin-bottom: 20px;
}

.order-items {
    list-style: none;
    padding: 0;
}

.order-item {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.order-item-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 15px;
}

.order-item-details {
    flex: 1;
}

.order-item-name {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.order-item-quantity {
    font-size: 0.9rem;
    color: #666;
}

.order-item-price {
    font-size: 1rem;
    color: #007bff;
}

/* Order Footer */
.order-footer {
    text-align: right;
}

.order-total {
    font-size: 1.25rem;
    color: #333;
}
</style>
@endsection
