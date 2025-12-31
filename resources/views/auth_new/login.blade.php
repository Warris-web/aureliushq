@extends('auth_new.app')

@section('content')
<div class="auth-img">
    <img class="img-fluid auth-bg" src="https://www.agrohandlers.com/uploaded_files/blog-pix/202309180828_ORGANIC-FOOD-STORE-BUSINESS-PLAN-IN-NIGERIA.jpg" alt="auth_bg" />
    <div class="auth-content">
        <div>
            <h2>Hello Again!</h2>
            <h4 class="p-0">Welcome back, You have been missed!</h4>
        </div>
    </div>
</div>

<form class="auth-form" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="custom-container">

        {{-- Email --}}
        <div class="form-group">
            <label for="inputusername" class="form-label">Email</label>
            <div class="form-input mb-2">
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" id="inputusername" placeholder="Enter Your Email" 
                       value="{{ old('email') }}" required autofocus />
                <i class="iconsax icons" data-icon="mail"></i>
            </div>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <label for="inputPassword" class="form-label">Password</label>
            <div class="form-input position-relative mb-2">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" id="inputPassword" placeholder="Enter Your Password" required />
                <i class="iconsax icons" data-icon="key"></i>
                <button type="button" class="toggle-password" onclick="togglePassword()" 
                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border:none; background:transparent; cursor:pointer;">
                    👁
                </button>
            </div>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Global Error (invalid credentials) --}}
        @if(session('error'))
            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
        @endif

        {{-- Options --}}
        <div class="option mt-3 d-flex justify-content-between">
            <a style="color:darkorange;" class="forgot " href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        {{-- Submit --}}
        <div class="submit-btn mt-3">
            <button type="submit" class="btn auth-btn w-100">Sign In</button>
        </div>

        <h4 class="signup mt-3">
            Don’t have an account? <a style="color:black; font-weignt:bold;" href="{{ route('register') }}"> Sign up</a>
        </h4>
    </div>
</form>

{{-- Show/Hide Password Script --}}
<script>
    function togglePassword() {
        let passField = document.getElementById("inputPassword");
        passField.type = passField.type === "password" ? "text" : "password";
    }
</script>
@endsection
