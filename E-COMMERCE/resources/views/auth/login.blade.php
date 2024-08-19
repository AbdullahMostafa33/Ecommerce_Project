@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Welcome Back!</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
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

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary auth-button">Login</button>
        </form>
        <div class="mt-4">
        <a href="/auth/redirect" class="google-login-button">
            <img src="https://w7.pngwing.com/pngs/326/85/png-transparent-google-logo-google-text-trademark-logo-thumbnail.png" alt="Google Logo" class="google-logo">
           sign in with Google
        </a>
        </div>
       
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
