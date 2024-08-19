@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="edit-profile-container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1>Edit Profile</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="edit-profile-form">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" >
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{$user->email}}" readonly>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="{{  $user->phone}}">
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="{{$user->address}}">
        </div>

        

        <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" id="image_file" name="image_file">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="/profile" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<style>
    .edit-profile-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 2rem;
        color: #333;
        margin-bottom: 20px;
    }

    .edit-profile-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        font-size: 1rem;
        color: #333;
        margin-bottom: 5px;
    }

    .form-group input, .form-group textarea {
        font-size: 1rem;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus, .form-group textarea:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
    }

    .btn {
        padding: 12px 20px;
        font-size: 1rem;
        border-radius: 6px;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease, transform 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: scale(1.05);
    }
</style>
@endsection
