@extends('layouts.admin')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
<div class="container">
    <h1>Notifications</h1>

    <div class="notification-actions">
        <form action="{{route('showNotifications.markAllAsRead')}}" style="display: inline-block;">
           
            <button type="submit" class="btn btn-success">Mark All as Read</button>
        </form>
        <form action="{{route('showNotifications.deleteAll')}}"  style="display: inline-block;">
            <button type="submit" class="btn btn-danger">Delete All</button>
        </form>
    </div>

    <ul class="list-group mt-4">
    
        @if (auth()->user()->unreadNotifications->count()>0)           
        
        @foreach(auth()->user()->unreadNotifications as $notification)
        <li class="list-group-item">
            @if($notification->type === 'App\Notifications\InvoicePaid')
                <a href="{{route('Notifications.markAsRead',[$notification->id,$notification->data['order_id']])}}">
                    Order #{{ $notification->data['order_id'] }} has been paid by {{ $notification->data['userCreate'] }}.
                </a>
            @endif
        </li>
        @endforeach
        @else
          <li class="list-group-item">
          <p>there in no Notifications ...</p>
        </li>
        @endif
    </ul>
</div>

<style>
    .notification-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }
</style>
@endsection
