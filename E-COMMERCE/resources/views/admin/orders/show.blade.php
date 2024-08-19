@extends('layouts.admin')

@section('title', 'Order')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
<div class="orders-container">
   

    <div class="orders-content">
        @if($order)
            <ul class="orders-list">
                    <li class="order-card">
                        <div class="order-header">
                            <h2>Order # </h2>
                            <p class="order-date">{{ $order->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="order-status">
                            <span class="status-label">Status:</span>
                            <span class="status-value">{{ $order->status }}</span>
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
                            
                          
                               <a class="btn btn-primary" href="{{route('invoice.show',$order->id)}}">show invoice</a>
                           

                           
                        </div>
                       
                    </li>
                    <br>
               
            </ul>
        @else
            <p>You have no order.</p>
        @endif

    </div>
    <div>
         <h2>Update Order Status</h2>
        <form action="{{route('admin.orders.status',$order->id)}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="status">Order Status</label>
                <select name="status_move" id="status_move" class="form-control">
                    <option value="pending" {{ $order->status_move == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status_move == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->status_move == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status_move == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
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
