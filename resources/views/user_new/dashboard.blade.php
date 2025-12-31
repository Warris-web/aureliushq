@extends('user_new.app')

@section('content')


<div id="preloader">
    <div class="loader-content">
        <img src="{{ asset('logo.png') }}" alt="Loading..." id="loader-logo">
    </div>
</div>

<style>
#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #fff; /* Change background if you prefer dark */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
}

#loader-logo {
    width: 120px; /* Adjust logo size */
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 0.6; }
    50% { transform: scale(1.15); opacity: 1; }
    100% { transform: scale(1); opacity: 0.6; }
}

#preloader.hide {
    opacity: 0;
    visibility: hidden;
}

</style>

<script>
window.addEventListener("load", function() {
    const preloader = document.getElementById("preloader");
    setTimeout(() => {
        preloader.classList.add("hide");
    }, 3000); // delay for smooth fade
});

</script>
<?php 
$has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
$has_done_kyc = has_done_kyc(Auth::user()->id);
$kycLevels = kyc_levels();
?>

{{-- KYC Modal --}}
@if(!$has_done_kyc)
<div class="modal fade" id="kycModal" tabindex="-1" aria-labelledby="kycModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content custom-modal">
      <div class="modal-header custom-header">
        <h5 class="modal-title" id="kycModalLabel">⚠️ KYC Required</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body custom-body">
        <p>
          You need to complete your <strong>KYC verification</strong> before continuing with your account usage.
        </p>
        <p class="small text-muted">
          This ensures your account is secured and compliant with regulations.
        </p>
      </div>
      <div class="modal-footer custom-footer">
        <a href="{{ route('onboarding_page') }}" class="btn btn-warning text-white fw-bold">Proceed to KYC</a>
        <button type="button" class="btn btn-dark text-white" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endif




{{-- Custom Styling --}}
<style>

.pwa-modal {
    background-color: #ffffff; /* Soft black */
    border-radius: 12px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.4);
}

.pwa-subtitle {
    color: #ffb347; /* Soft orange */
}

.btn-warning {
    background-color: #ff8c00;
    border: none;
}

.btn-outline-warning {
    border-color: #ff8c00;
    color: #ff8c00;
}

.btn-outline-warning:hover {
    background-color: #ff8c00;
    color: #fff;
}

.custom-modal {
  border-radius: 12px;
  overflow: hidden;
  color: #fff;
  {{-- box-shadow: 0 8px 25px rgba(0,0,0,0.7); --}}
}

.custom-header {
  background: #ff6600; /* Dark Orange */
  color: #fff;
  border-bottom: none;
  padding: 1rem 1.5rem;
}

.custom-body {
  padding: 1.5rem;
  font-size: 15px;
  line-height: 1.6;
}

.custom-footer {
  border-top: 1px solid rgba(255,255,255,0.1);
  padding: 1rem 1.5rem;
}

.btn-warning {
  background: #ff6600 !important;
  border: none;
  transition: 0.3s;
}

.btn-warning:hover {
  background: #e65c00 !important;
}

.btn-outline-light {
  border: 1px solid #fff;
}

.btn-outline-light:hover {
  background: #fff;
  color: #000;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    @if(!$has_done_kyc)
        var kycModal = new bootstrap.Modal(document.getElementById('kycModal'));
        kycModal.show();
    @elseif(!$has_paid_onboarding)
        var onboardingModal = new bootstrap.Modal(document.getElementById('onboardingModal'));
        onboardingModal.show();
    @endif
});
</script>




<!-- banner section start -->
   <section class="banner-wrapper">
  <div class="custom-container">
  <div class="balance-card text-center rounded-4 shadow-sm">
    
  <!-- Top balances -->
  <div class="row g-0 balance-header">
    <div class="col-6 border-end">
      <div class="balance-amount">₦{{ number_format(Auth::user()->wallet_balance) }}</div>
      <div class="balance-label">Wallet Bal</div>
    </div>
    <div class="col-6">
      <div class="balance-amount">₦{{ number_format(Auth::user()->loan_balance) }}</div>
      <div class="balance-label">Outstanding Bal</div>
    </div>
  </div>

  <!-- Account section -->
  <div class="account-section p-2">
    @if(empty(Auth::user()->virtual_account_number))


    @if($has_paid_onboarding && $has_done_kyc)
    
      <h6 class="mb-1 fw-bold text-dark">Virtual Account</h6>
      <p class="text-muted small mb-2">Generate your personal account number</p>
      <button class="btn btn-darkorange w-100 btn-sm" id="generateBtn" onclick="generateAccount()">
        <span id="btnText">Generate Account Number</span>
        <i id="spinner" class="fas fa-spinner fa-spin d-none ms-2"></i>
      </button>
@else
    {{-- Show Complete Onboarding Button --}}
    <a href="{{ route('onboarding_page') }}" class="btn btn-secondary w-100 btn-sm">
        Activate Account
    </a>
@endif

    @else
      @php
        $accountData = json_decode(Auth::user()->virtual_account_number, true);
      @endphp
      <div class="account-inline">
        <span class="account-number fw-bold text-darkorange" id="accountNumber">
          {{ $accountData['account_number'] ?? '' }}
        </span>
        <button class="btn btn-copy ms-2" onclick="copyAccountNumber()" id="copyBtn" title="Copy">
          <i class="fas fa-copy"></i>
        </button>
      </div>
      <div class="bank-info small text-muted">
        <strong>{{ $accountData['bank'] ?? '' }}</strong> — {{ $accountData['account_name'] ?? '' }}
      </div>
    @endif
  </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="copyToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-darkorange text-white">
      <i class="fas fa-check-circle me-2"></i>
      <strong class="me-auto">Success</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body text-dark">
      Account number copied to clipboard!
    </div>
  </div>
</div>

<style>
/* Card */
.balance-card {
  max-width: 90%;
  margin: auto;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
}

/* Header */
.balance-header {
  background: rgba(0,0,0,0.7);
  color: darkorange;
  padding: 0.4rem 0; /* smaller height */
  font-weight: 600;
}
.balance-amount {
  font-size: 1rem;
  font-weight: 700;
}
.balance-label {
  font-size: 0.7rem;
  opacity: 0.9;
}

/* Account section */
.account-section {
  padding-top: 0.4rem;
  padding-bottom: 0.4rem;
}
.account-inline {
  display: flex;
  align-items: center;
  justify-content: center;
}
.account-number {
  font-size: 0.9rem;
  letter-spacing: 0.5px;
  white-space: nowrap;
}
.text-darkorange {
  color: darkorange !important;
}
.bank-info {
  line-height: 1.1;
  margin-top: 2px;
}

/* Copy button (small and compact) */
.btn-copy {
  background: transparent;
  border: 1px solid darkorange;
  color: darkorange;
  padding: 2px 6px;   /* keeps it tiny */
  font-size: 0.8rem;
  line-height: 1;
  border-radius: 5px;
}
.btn-copy:hover {
  background: darkorange;
  color: #fff;
}

/* Buttons */
.btn-darkorange {
  background: darkorange;
  border: none;
  color: #fff;
  font-weight: 600;
  transition: 0.3s;
}
.btn-darkorange:hover {
  background: #e67300;
}

/* Toast */
.bg-darkorange {
  background: darkorange !important;
}
#dashboard_food_display{
      background: #fff7f4; /* light orange */
      padding:20px;

}
</style>

<script>
function copyAccountNumber() {
    const accountNumber = document.getElementById('accountNumber').textContent;
    const copyBtn = document.getElementById('copyBtn');
    const toast = new bootstrap.Toast(document.getElementById('copyToast'));
    
    // Copy to clipboard
    navigator.clipboard.writeText(accountNumber).then(function() {
        // Change button appearance
        copyBtn.innerHTML = '<i class="fas fa-check"></i>';
        copyBtn.classList.add('copied');
        
        // Show toast
        toast.show();
        
        // Reset button after 2 seconds
        setTimeout(() => {
            copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
            copyBtn.classList.remove('copied');
        }, 2000);
        
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = accountNumber;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            copyBtn.innerHTML = '<i class="fas fa-check"></i>';
            copyBtn.classList.add('copied');
            toast.show();
            
            setTimeout(() => {
                copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
                copyBtn.classList.remove('copied');
            }, 2000);
        } catch (err) {
            console.error('Fallback copy failed: ', err);
        }
        
        document.body.removeChild(textArea);
    });
}

function generateAccount() {
    let btn = document.getElementById("generateBtn");
    let spinner = document.getElementById("spinner");
    let btnText = document.getElementById("btnText");

    // Save the original text
    let originalText = btnText.textContent;

    btn.disabled = true;
    btnText.textContent = "Generating...";
    spinner.classList.remove("d-none");

    fetch("{{ route('generate_virtual_account') }}", {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === true) {
            showSessionModal("success","Account generated successfully!");
            location.reload();
        } else {
            showSessionModal("error", "Failed to generate account: " + (data.message || "Unknown error"));
        }
    })
    .catch(err => {
        alert("Error: " + err.message);
    })
    .finally(() => {
        btn.disabled = false;
        btnText.textContent = originalText;
        spinner.classList.add("d-none");
    });
}
</script>
    <!-- banner section start -->

    
    <?php
// Demo ambassador data
$ambassadors = $settings->slider_images ?? null;

if (is_null($ambassadors)) {
    $ambassadors = [];
} else {
    $ambassadors = json_decode($ambassadors, true) ?? [];
    $ambassadors = array_filter($ambassadors); // Removes all null values
}

 
?>

<style>
/* Ambassador Section */
.ambassador-section {
  max-width: 90%;
  margin: 15px auto;
  border-radius: 12px;
  overflow: hidden;
  position: relative;
  text-align: center;
}

/* Image as banner */
.ambassador-banner {
  width: 100%;
  height: 120px; /* adjust as needed */
  object-fit: cover;
  display: block;
}

/* Indicators (dots) */
.carousel-indicators {
  position: static;  /* remove absolute positioning */
  margin-top: 8px;   /* space between image and dots */
}
.carousel-indicators [data-bs-target] {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: rgba(0,0,0,0.4);
}
.carousel-indicators .active {
  background-color: #ff6600; /* active dot color */
}
</style>

<!-- Ambassador Slider -->
<div class="ambassador-section">
  <div id="ambassadorCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

    <!-- Slides -->
    <div class="carousel-inner">
      <?php foreach ($ambassadors as $index => $amb): ?>
        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
          <img src="<?= $amb?>" class="ambassador-banner" alt="Ambassador">
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Dots (Indicators below) -->
    <div class="carousel-indicators">
      <?php foreach ($ambassadors as $index => $amb): ?>
        <button type="button" data-bs-target="#ambassadorCarousel" data-bs-slide-to="<?= $index ?>" 
          class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index+1 ?>"></button>
      <?php endforeach; ?>
    </div>
  </div>
</div>


    
    <!-- Foods Section Start -->
<section id="dashboard_food_display" class="section-t-space">
    <div class="custom-container">
        <div class="title d-flex justify-content-between align-items-center">
            <h2>Most Popular Foods</h2>
            <a href="{{ route('user.packages') }}">View All</a>
        </div>

        <div class="row g-4">
            @if(count($foods) > 0)
                @foreach($foods as $food)
                    <div class="col-6">
                        <div class="product-box">
                            <div class="product-box-img">
                                                                <h5 class="badge bg-warning">{{ optional($food->cat)->name ?? 'Uncategorized' }}</h5>

                                <a href="{{ route('shop.detail', $food->slug) }}">
                                    <img class="img" 
                                         src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                                         alt="{{ $food->name }}" />
                                </a>

                                {{-- <div class="cart-box">
                                    <a href="javascript:void(0)" 
                                       onclick="addToCart({{ $food->id }}, '{{ addslashes($food->name) }}', {{ $food->amount }})" 
                                       class="cart-bag">
                                        <i class="iconsax bag" data-icon="basket-2"></i>
                                    </a>
                                </div> --}}
                            </div>

                            {{-- Like / Favorite button --}}
                            {{-- <div class="like-btn animate inactive">
                                <img class="outline-icon" src="{{ asset('assets/images/svg/like.svg') }}" alt="like" />
                                <img class="fill-icon" src="{{ asset('assets/images/svg/like-fill.svg') }}" alt="like" />
                                <div class="effect-group">
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                    <span class="effect"></span>
                                </div>
                            </div> --}}

                            <div class="product-box-detail">
                                <h4>{{ $food->name }}</h4>
                                <div class="d-flex justify-content-between gap-3">
                                    <h3 class="fw-semibold">₦{{ number_format($food->amount, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            @else
                <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 50vh;">
                    <div class="text-center p-5 border rounded-4 shadow-sm bg-light" style="max-width: 500px;">
                        <div class="mb-3">
                            <i class="fas fa-box-open fa-4x text-muted"></i>
                        </div>
                        <h4 class="fw-bold text-secondary">No Products Available</h4>
                        <p class="text-muted">Please check back later for amazing updates 🌟</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Foods Section End -->
 <!-- other furniture section end -->



    <!-- banner section start -->
    {{-- <section class="banner-wapper grid-banner">
      <div class="custom-container">
        <div class="row">
          <div class="col-6">
            <div class="banner-bg">
              <img class="img-fluid img-bg" src="assets/images/banner/banner-3.jpg" alt="banner-3" />
              <div class="banner-content">
                <h3>Wingback Chair</h3>
              </div>
              <a href="shop.html" class="more-btn d-block">
                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                <h3>View More</h3>
              </a>
              <div class="banner-bg"></div>
            </div>
          </div>

          <div class="col-6">
            <div class="banner-bg">
              <img class="img-fluid img-bg" src="assets/images/banner/banner-4.jpg" alt="banner-3" />
              <div class="banner-content">
                <h3>Wingback Chair</h3>
              </div>
              <a href="shop.html" class="more-btn d-block">
                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                <h3>View More</h3>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section> --}}
    <!-- banner section end -->



@endsection