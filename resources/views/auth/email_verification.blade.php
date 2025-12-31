@extends('auth_new.app')

@section('content')
<div class="auth-img">
    <img class="img-fluid auth-bg" src="https://www.agrohandlers.com/uploaded_files/blog-pix/202309180828_ORGANIC-FOOD-STORE-BUSINESS-PLAN-IN-NIGERIA.jpg" alt="auth_bg" />
    <div class="auth-content">
        <div>
            <h2>Email Verification</h2>
            <h4 class="p-0">Enter the OTP sent to your email</h4>
        </div>
    </div>
</div>

<form class="auth-form" method="POST" action="{{ route('otp.verify.submit') }}">
    @csrf
    <div class="custom-container">

        {{-- OTP Input Fields --}}
        <div class="form-group">
            <label class="form-label">OTP</label>
            <div class="otp-input-group d-flex gap-2 mb-2">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" name="otp[]" maxlength="1" 
                           class="otp-input form-control text-center @error('otp')  @enderror" 
                           required>
                @endfor
            </div>
            @error('otp')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Global Error (wrong OTP) --}}
        @if(session('error'))
            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
        @endif

        {{-- Success Message --}}
        @if(session('status'))
            <div class="alert alert-success mt-2">{{ session('status') }}</div>
        @endif

        {{-- Submit --}}
        <div class="submit-btn mt-3">
            <button type="submit" class="btn auth-btn w-100">Verify OTP</button>
        </div>

        {{-- Resend OTP --}}
        <div class="mt-3 text-center">
            <form action="{{ route('otp.resend') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link">Resend OTP</button>
            </form>
        </div>

        <p class="mt-3"><a href="{{ route('login') }}">Back to Login</a></p>
    </div>
</form>

{{-- OTP Auto Navigation --}}
<script>
document.querySelectorAll('.otp-input').forEach((input, index, arr) => {
    input.addEventListener('input', function () {
        if (this.value.length === 1 && index < arr.length - 1) {
            arr[index + 1].focus();
        }
    });
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
            arr[index - 1].focus();
        }
    });
});
</script>

{{-- OTP Styles --}}
<style>
.otp-input-group {
    display: flex;
    justify-content: center;
}
.otp-input {
    width: 50px;
    height: 50px;
    font-size: 20px;
    text-align: center;
    border-radius: 8px;
}
</style>
@endsection
