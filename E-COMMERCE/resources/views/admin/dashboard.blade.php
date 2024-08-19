@extends('layouts.admin')

@section('content')
<div class="dashboard-container">
    <div class="stats-overview">
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p>{{$count_order}}</p>
           @if ($percent_order>0)
             <span class="stat-change positive">+{{$percent_order}}% from last month</span>
            @else
             @if ($percent_order==0)  <span class="stat-change neutral">No change</span>
            @else  <span class="stat-change negative">{{$percent_order}}% from last month</span>
            @endif
            @endif
        </div>
        <div class="stat-card">
            <h3>Total Revenue</h3>
            <p>${{$total_current}}</p>
             @if ($percent_total>0)
             <span class="stat-change positive">+{{$percent_total}}% from last month</span>
            @else
             @if ($percent_total==0)  <span class="stat-change neutral">No change</span>
            @else  <span class="stat-change negative">{{$percent_total}}% from last month</span>
            @endif
            @endif
        </div>
        <div class="stat-card">
            <h3>New Customers</h3>
            <p>{{ $usersThisMonth}}</p>
            @if ($percent_user>0)
             <span class="stat-change positive">+{{$percent_user}}% from last month</span>
            @else
             @if ($percent_user==0)  <span class="stat-change neutral">No change</span>
            @else  <span class="stat-change negative">{{$percent_user}}% from last month</span>
            @endif
            @endif
           
        </div>
        <div class="stat-card">
            <h3>Pending Orders</h3>
            <p>{{ $count_pending}}</p>
            @if ($percent_pending>0)
             <span class="stat-change positive">+{{$percent_pending}}% from last month</span>
            @else
             @if ($percent_pending==0)  <span class="stat-change neutral">No change</span>
            @else  <span class="stat-change negative">{{$percent_pending}}% from last month</span>
            @endif
            @endif
        </div>
    </div>

    <div class="charts-section">
        <div class="chart-card">
            <h3>Revenue Breakdown</h3>
            <canvas id="revenueChart"></canvas>
        </div>
        <div class="chart-card">
            <h3>Order Status Overview</h3>
            <canvas id="orderStatusChart"></canvas>
        </div>
    </div>

    <div class="recent-orders-section">
        <h3>Recent Orders</h3>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $last_orders as $order)
                    <tr>
                    <td>#{{$order->id}}</td>
                    <td>{{$order->user->name}}</td>
                    <td>{{$order->created_at->format('M j, Y')}}</td>
                    <td>{{$order->status_move}}</td>
                    <td>{{$order->total_price}}</td>
                    <td>
                        <form action="{{route('admin.orders.show',$order->id)}}">
                             <button class="btn btn-edit">View</button>
                        </form>
                       
                    </td>
                </tr> 
                @endforeach
            
               
             
            </tbody>
        </table>
    </div>
</div>

<style>
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
        padding: 40px;
        background-color: #f4f7fc;
    }

    .stats-overview {
        display: flex;
        gap: 20px;
    }

    .stat-card {
        flex: 1;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .stat-card h3 {
        margin-bottom: 10px;
        font-size: 1.5rem;
        color: #333;
    }

    .stat-card p {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #007bff;
    }

    .stat-change {
        font-size: 0.9rem;
        padding: 5px;
        border-radius: 12px;
    }

    .stat-change.positive {
        background-color: #d4edda;
        color: #155724;
    }

    .stat-change.negative {
        background-color: #f8d7da;
        color: #721c24;
    }

    .stat-change.neutral {
        background-color: #ffeeba;
        color: #856404;
    }

    .charts-section {
        display: flex;
        gap: 20px;
    }

    .chart-card {
        flex: 1;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .chart-card h3 {
        margin-bottom: 20px;
        font-size: 1.5rem;
        color: #333;
    }

    .recent-orders-section {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .recent-orders-section h3 {
        margin-bottom: 20px;
        font-size: 1.5rem;
        color: #333;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table th, .orders-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    .orders-table th {
        background-color: #f9f9f9;
        font-weight: bold;
    }

    .orders-table td {
        background-color: #fff;
    }

    .btn {
        padding: 8px 15px;
        font-size: 0.9rem;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background-color: #007bff;
        color: #fff;
    }

    .btn-view:hover {
        background-color: #0056b3;
    }

    .btn-edit {
        background-color: #28a745;
        color: #fff;
    }

    .btn-edit:hover {
        background-color: #218838;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','Aug'],
            datasets: [{
                label: 'Revenue',
                data:{!! json_encode($months) !!},
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    const ctxOrderStatus = document.getElementById('orderStatusChart').getContext('2d');
    const orderStatusChart = new Chart(ctxOrderStatus, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Processing', 'Pending', 'Cancelled'],
            datasets: [{
                label: 'Order Status',
                data: [{{$count_completed}}, {{$count_processing}}, {{$count_pending}}, {{$count_cancelled}}],
                backgroundColor: ['#28a745', '#ffc107', '#007bff', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection
