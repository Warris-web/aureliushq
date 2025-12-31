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

<form class="auth-form" id="verifyOtpForm" method="POST" action="{{ route('otp.verify.submit') }}">
    @csrf
    <div class="custom-container">

        {{-- OTP Input Fields --}}
        <div class="form-group">
            <div class="otp-input-group d-flex justify-content-center gap-2 mb-2">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" name="otp[]" maxlength="1"
                           class="otp-input form-control text-center"
                           required>
                @endfor
            </div>
            <div id="otpMessage" class="text-center mt-2"></div>
        </div>

        {{-- Verify Button --}}
        <div class="submit-btn mt-3">
            <button type="submit" class="btn auth-btn w-100">
                <i class="fa fa-spin fa-spinner d-none me-2" id="verifyLoader"></i>
                Verify OTP
            </button>
        </div>

        {{-- Action Buttons Container --}}
        <div class="action-buttons mt-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <button type="button" id="resendOtpBtn" class="btn btn-outline-success">
                    <i class="fa fa-spin fa-spinner d-none me-2" id="resendLoader"></i>
                    Resend OTP
                </button>
                <a href="{{ route('logout') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-left me-1"></i>
                    Back to Login
                </a>
            </div>
        </div>
    </div>
</form>

{{-- Font Awesome CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- OTP Auto Navigation + AJAX --}}
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
    // Allow only numeric input
    input.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});

// ✅ AJAX Verify OTP
document.getElementById('verifyOtpForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const form = this;
    const loader = document.getElementById('verifyLoader');
    const messageBox = document.getElementById('otpMessage');

    loader.classList.remove('d-none');
    messageBox.innerHTML = "";

    fetch(form.action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": form.querySelector('[name=_token]').value,
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            otp: Array.from(form.querySelectorAll('input[name="otp[]"]'))
                      .map(input => input.value)
                      .join('') // ✅ join array into string e.g. "123456"
        })
    })
    .then(async res => {
        let data;
        try {
            data = await res.json();
        } catch (err) {
            throw new Error(`Invalid JSON response. HTTP status: ${res.status}`);
        }

        if (res.ok) {
            // ✅ Success or failed but 200 OK
            if (data.status) {
                messageBox.innerHTML = `<span class="text-success"><i class="fa fa-check-circle"></i> ${data.message}</span>`;
                setTimeout(() => window.location.href = "{{ route('check_login') }}", 1200);
            } else {
                messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-circle"></i> ${data.message}</span>`;
                // Clear OTP inputs for retry
                form.querySelectorAll('input[name="otp[]"]').forEach(input => input.value = '');
            }
        } else {
            // ❌ Handle 400/422/etc
            messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-circle"></i> ${data.message || 'Something went wrong.'}</span>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> ${error.message}</span>`;
    })
    .finally(() => loader.classList.add('d-none'));
});


// ✅ AJAX Resend OTP
document.getElementById('resendOtpBtn').addEventListener('click', function () {
    const loader = document.getElementById('resendLoader');
    const messageBox = document.getElementById('otpMessage');

    loader.classList.remove('d-none');
    messageBox.innerHTML = "";

    fetch("{{ route('otp.resend') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('[name=_token]').value,
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        if (data.success) {
            messageBox.innerHTML = `<span class="text-success"><i class="fa fa-check-circle"></i> ${data.message}</span>`;
            // Clear OTP inputs after successful resend
            document.querySelectorAll('.otp-input').forEach(input => input.value = '');
            document.querySelector('.otp-input').focus();
        } else if (data.message) {
            messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-circle"></i> ${data.message}</span>`;
        } else {
            messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-circle"></i> Unexpected response format</span>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageBox.innerHTML = `<span class="text-danger"><i class="fa fa-exclamation-triangle"></i>ç Failed to resend OTP. Please try again.</span>`;
    })
    .finally(() => loader.classList.add('d-none'));
});
</script>

{{-- OTP Styles --}}
<style>
.otp-input {
    width: 50px;
    height: 50px;
    font-size: 20px;
    text-align: center;
    border-radius: 8px;
    border: 2px solid #ddd;
    transition: border-color 0.3s ease;
}

.otp-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

.action-buttons {
    margin-top: 1.5rem;
}

.action-buttons .btn {
    min-width: 140px;
    padding: 8px 16px;
    font-weight: 500;
}

.action-buttons .btn i {
    font-size: 0.9em;
}

@media (max-width: 576px) {
    .action-buttons .d-flex {
        flex-direction: column;
        gap: 0.75rem !important;
    }
    
    .action-buttons .btn {
        width: 100%;
        min-width: auto;
    }
}

/* Message styling */
#otpMessage i {
    margin-right: 5px;
}
</style>
@endsection