@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
@if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-picture">
            <img src="{{ $user->image ? asset($user->image) : 'https://via.placeholder.com/150' }}" alt="{{ $user->name }}">
        </div>
        <div class="profile-info">
            <h1>{{ $user->name }}</h1>
            <p class="email">{{ $user->email }}</p>
            <p class="joined">Joined on {{ $user->created_at->format('F d, Y') }}</p>
        </div>
    </div>

    
        <h2>Contact Details</h2>
        <p><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
        <p><strong>Address:</strong> {{ $user->address ?? 'Not provided' }}</p>
        
        <h2>Settings</h2>
        <a href="{{ route('profile.edit') }}" class="btn btn-edit">Edit Profile</a>
    </div>
</div>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: #f4f7f6;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .profile-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .profile-header {
        display: flex;
        align-items: center;
        padding-bottom: 20px;
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 30px;
        background: linear-gradient(135deg, #f9f9f9, #ffffff);
        border-radius: 12px;
    }

    .profile-picture {
        flex: 0 0 150px;
        margin-right: 20px;
    }

    .profile-picture img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #007bff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .profile-info h1 {
        font-size: 2.5rem;
        color: #333;
        margin: 0;
        transition: color 0.3s ease;
    }

    .profile-info h1:hover {
        color: #007bff;
    }

    .profile-info .email {
        font-size: 1.2rem;
        color: #007bff;
    }

    .profile-info .joined {
        font-size: 1rem;
        color: #666;
    }

    .profile-body h2 {
        font-size: 1.6rem;
        color: #007bff;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
        position: relative;
        transition: color 0.3s ease;
    }

    .profile-body h2::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 3px;
        background: rgba(0, 123, 255, 0.3);
        transition: background 0.3s ease;
    }

    .profile-body h2:hover::after {
        background: #007bff;
    }

    .profile-body p {
        font-size: 1.1rem;
        color: #333;
        line-height: 1.6;
        margin: 10px 0;
    }

    .btn-edit {
        display: inline-block;
        padding: 12px 20px;
        font-size: 1.1rem;
        color: #fff;
        background-color: #007bff;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-edit:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-picture {
            margin-right: 0;
            margin-bottom: 20px;
        }

        .profile-info h1 {
            font-size: 2rem;
        }

        .profile-info .email {
            font-size: 1rem;
        }

        .profile-info .joined {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
