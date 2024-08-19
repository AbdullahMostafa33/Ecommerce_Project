@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
<div class="admin-orders-container">
    <h1>Manage Orders</h1>

    <div class="admin-filters">
        <div class="filter-status">
           <form action="{{route('admin.orders.index')}}">
             <select name="status_move" class="filter-select">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button class="button">Filter by Status</button>
           </form>

        </div>
        <div class="filter-search">
            <form action="{{route('admin.orders.index')}}">
            <input type="text" name="search" class="search-input" placeholder="Search by customer name or order ID">
            <button class="button">Search</button>
            </form>

        </div>
    </div>

    <div class="admin-orders-content">
        @if($orders)
            <table class="admin-orders-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>order id</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>status_move</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="orders-table-body">
                    <?php $i=0;?>
                    @foreach($orders as $order)
                        <tr class="admin-order-row">
                            <td>{{++$i }}</td>
                            <td>{{$order->id}}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format('F d, Y') }}</td>
                            <td>
                                <ul class="admin-order-items">
                                    @foreach($order->orderItems as $item)
                                        <li>{{ $item->product->name }} (x{{ $item->quantity }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>${{ $order->total_price }}</td>
                            <td class="order-status">{{ ucfirst($order->status) }}</td>
                            <td class="order-status">{{ ucfirst($order->status_move) }}</td>

                            <td>                                
                                <a href="{{route('admin.orders.show',$order->id)}}" class="btn btn-info action-btn">View</a>
                                <a class="btn btn-danger delete-order-btn" href="{{route('admin.order.delete',$order->id )}}">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No orders to manage.</p>
        @endif
    </div>
</div>

<style>
/* Admin Orders Container */
.admin-orders-container {
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

/* Admin Filters */
.admin-filters {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.filter-status, .filter-search {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.filter-select, .search-input {
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    margin-bottom: 4px;
    width: 100%;
}

/* Admin Orders Content */
.admin-orders-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* Admin Orders Table */
.admin-orders-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-orders-table th, .admin-orders-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.admin-orders-table th {
    background-color: #f2f2f2;
    color: #333;
}

.admin-orders-table tr:hover {
    background-color: #f1f1f1;
}

/* Admin Order Row */
.admin-order-row td {
    vertical-align: top;
}

.admin-order-items {
    list-style: none;
    padding: 0;
    margin: 0;
}

.admin-order-items li {
    margin-bottom: 5px;
}

/* Order Status */
.order-status {
    font-weight: bold;
    color: #007bff;
}

/* Order Status Select */
.order-status-select {
    width: 100%;
    padding: 5px;
    border-radius: 4px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

/* Action Buttons */
.action-btn {
    display: inline-block;
    margin: 5px 0;
    padding: 10px 15px;
    border-radius: 4px;
    text-align: center;
    text-decoration: none;
    color: #fff;
    transition: background-color 0.3s ease;
}
.button {
  text-decoration: none; 
  display: inline-block; 
  padding: 10px 20px; 
  background-color: #f1f1f1; 
 border: none;
  border-radius: 5px; 
  cursor: pointer;
}

.btn-info {
    background-color: #17a2b8;
}

.btn-info:hover {
    background-color: #138496;
}

.btn-warning {
    background-color: #ffc107;
    color: #000;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
}
</style>
@endsection

