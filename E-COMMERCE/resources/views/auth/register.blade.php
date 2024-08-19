@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Create an Account</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary auth-button">Register</button>
        </form>
<div class="mt-4">
        <a href="/auth/redirect" class="google-login-button">
            <img src="https://w7.pngwing.com/pngs/326/85/png-transparent-google-logo-google-text-trademark-logo-thumbnail.png" alt="Google Logo" class="google-logo">
           sign up with Google
        </a>
        </div>
        <a class="auth-link" href="{{ route('login') }}">Already have an account? Login</a>
    </div>
</div>

<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-image: url('your-background-image.jpg');
        background-size: cover;
        background-position: center;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.9);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
    }

    .auth-title {
        font-size: 2rem;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        width: 100%;
        font-size: 1rem;
    }

    .auth-link {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #007bff;
    }
 .google-login-button {
  display: flex;
  align-items: center;
  background-color: #4285F4; /* Google's blue color */
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.google-login-button:hover {
  background-color: #357AE8; /* Slightly darker blue on hover */
}

.google-logo {
  height: 20px;
  width: 20px;
  margin-right: 10px;
}

    </style>

@endsection
