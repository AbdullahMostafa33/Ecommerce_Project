<!-- resources/views/invoices/show.blade.php -->
@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="invoice-container">
    <div class="invoice-header">
        <h1>Invoice #{{ $order->payment->invoice_id }}</h1>
        <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
    </div>

    <div class="invoice-body">
        <h3>Customer Details</h3>
        <p><strong>Name:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>

        <h3>Order Details</h3>
        <table class="order-details">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ $item->product->price }}</td>
                    <td>${{ $item->quantity * $item->product->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Payment Details</h3>
        <p><strong>Payment Method:</strong> {{ $order->payment->payment_gateway }}</p>
        <p><strong>Transaction ID:</strong> {{ $order->payment->transaction_id }}</p>
        <p><strong>Total Paid:</strong> ${{ $order->payment->transaction_value }}</p>
        <p><strong>Status:</strong> {{ $order->payment->transaction_status }}</p>
    </div>

    <div class="invoice-footer">
        <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
    </div>
</div>

<style>
.invoice-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.invoice-header, .invoice-body, .invoice-footer {
    margin-bottom: 20px;
}

.invoice-header h1 {
    font-size: 2rem;
    margin-bottom: 10px;
    color: #333;
}

.invoice-body h3 {
    margin-top: 20px;
    font-size: 1.2rem;
    color: #333;
}

.order-details {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.order-details th, .order-details td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.order-details th {
    background-color: #f4f4f4;
    color: #333;
}

.invoice-footer {
    text-align: right;
}

.invoice-footer .btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.invoice-footer .btn:hover {
    background-color: #0056b3;
}
</style>
@endsection
