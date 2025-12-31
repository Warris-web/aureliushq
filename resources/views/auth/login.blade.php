@extends('auth.app')

@section('content')
<style>
    .login-container {
        display: flex;
        min-height: 100vh;
        background: #f8f9fa;
        flex-wrap: wrap;
    }
    .login-image {
        flex: 1;
        background: url('https://www.agrohandlers.com/uploaded_files/blog-pix/202309180828_ORGANIC-FOOD-STORE-BUSINESS-PLAN-IN-NIGERIA.jpg') no-repeat center center;
        background-size: cover;
    }
    .login-form-section {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px;
        background: #fff;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    }
    .login-card {
        width: 100%;
        max-width: 400px;
    }
    .login-card h4 {
        margin-bottom: 20px;
        color: #333;
    }
    .login-card .form-control {
        border-radius: 8px;
        padding: 10px;
    }
    .login-card button {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-size: 16px;
    }
    .login-card .text-blue {
        color: #007bff;
        text-decoration: none;
    }
    .login-card .text-blue:hover {
        text-decoration: underline;
    }
    .brand-logo {
        text-align: center;
        margin-bottom: 20px;
    }
    .brand-logo img {
        max-width: 180px;
    }

    /* ✅ Hide image on small screens */
    @media (max-width: 768px) {
        .login-image {
            display: none;
        }
        .login-form-section {
            flex: 1 1 100%;
            box-shadow: none;
        }
    }
</style>

<div class="login-container">
    <!-- Left Image -->
    <div class="login-image"></div>

    <!-- Right Login Form -->
    <div class="login-form-section">
        <div class="login-card">
            <div class="brand-logo">
                <a href="#">
                    <img src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" alt="Logo">
                </a>
            </div>

            <h4>Sign In</h4>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                        <small style="color:red; font-weight:bolder;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    @error('password')
                        <small style="color:red; font-weight:bolder;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <p><a class="text-blue" href="{{ route('password.request') }}">Forgot Password?</a></p>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>

                <p class="mt-3">Don't have an account yet? 
                    <a class="text-blue" href="{{ route('register') }}">Sign Up</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
