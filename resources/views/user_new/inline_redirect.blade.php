@extends('user_new.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-center">
        <div class="card shadow" style="max-width: 480px; width: 100%; border-radius: 16px;">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-lock fa-3x text-warning"></i>
                </div>
                <h4 class="mb-2">Access Restricted</h4>
                <p class="text-muted mb-4">{{ $message }}</p>
                <div class="display-5 fw-bold mb-3" id="countdown">5</div>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; transition: width 5s linear;"></div>
                </div>
                <button class="btn btn-primary w-100" id="proceedNow">
                    Proceed Now
                </button>
                <small class="text-muted d-block mt-2">You will be redirected automatically</small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trigger same modal behavior as checkout snippet
        showSessionModal('error', @json($message));

        let countdown = 5;
        const countdownEl = document.getElementById('countdown');
        const progressBar = document.querySelector('.progress-bar');
        const redirectUrl = @json($redirect_url);

        const timer = setInterval(() => {
            countdown--;
            countdownEl.textContent = countdown;
            if (progressBar) {
                progressBar.style.width = `${(countdown / 5) * 100}%`;
            }
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = redirectUrl;
            }
        }, 1000);

        document.getElementById('proceedNow').addEventListener('click', () => {
            clearInterval(timer);
            window.location.href = redirectUrl;
        });
    });
</script>
@endsection
