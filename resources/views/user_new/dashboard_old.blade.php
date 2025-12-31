@extends('user_new.app')

@section('content')
<!-- banner section start -->
   <section class="banner-wrapper">
  <div class="custom-container">
  <div class="balance-card text-center rounded-4 shadow-sm">

  <!-- Top balances -->
  <div class="row g-0 balance-header">
    <div class="col-6 border-end">
      <div class="balance-amount">₦{{ number_format(Auth::user()->wallet_balance) }}</div>
      <div class="balance-label">Wallet</div>
    </div>
    <div class="col-6">
      <div class="balance-amount">₦{{ number_format(Auth::user()->loan_balance) }}</div>
      <div class="balance-label">Loan</div>
    </div>
  </div>

  <!-- Account section -->
  <div class="account-section p-2">
    @if(empty(Auth::user()->virtual_account_number))
      <h6 class="mb-1 fw-bold text-dark">Virtual Account</h6>
      <p class="text-muted small mb-2">Generate your personal account number</p>
      <button class="btn btn-darkorange w-100 btn-sm" id="generateBtn" onclick="generateAccount()">
        <span id="btnText">Generate Account Number</span>
        <i id="spinner" class="fas fa-spinner fa-spin d-none ms-2"></i>
      </button>
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
        <strong>{{ $accountData['bank']['name'] ?? '' }}</strong> — {{ $accountData['account_name'] ?? '' }}
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
  border: 1px dashed black; /* dashed border */
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
            alert("Account generated successfully!");
            location.reload();
        } else {
            alert("Failed to generate account: " + (data.message || "Unknown error"));
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
$ambassadors = [
    ["name" => "John Doe", "role" => "Top Ambassador", "image" => asset('assets/banner.jpg')],
    ["name" => "Jane Smith", "role" => "Brand Ambassador", "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSMDNk-w0MsmcNFxCas0QhU62Tfpn3OLgohA&s"],
    ["name" => "Mike Johnson", "role" => "Community Ambassador", "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPjR3Q-NqrZiPRllsJXOuBrr_0t8hOAsG-ZA&s"],
];
?>

<style>
/* Ambassador Section */
.ambassador-section {
  max-width: 90%;
  margin: 15px auto;
  border-radius: 12px;
  overflow: hidden;
  border: 1px dashed rgba(0,0,0,0.4);
  position: relative;
}

/* Image as banner */
.ambassador-banner {
  width: 100%;
  height: 120px; /* adjust as needed */
  object-fit: cover;
  display: block;
}

/* Controls (tiny and stylish) */
.carousel-control-prev,
.carousel-control-next {
  width: 25px;
  height: 25px;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(0,0,0,0.3);
  border-radius: 50%;
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
  width: 14px;
  height: 14px;
}
</style>

<!-- Ambassador Slider -->
<div class="ambassador-section">
  <div id="ambassadorCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
      <?php foreach ($ambassadors as $index => $amb): ?>
        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
          <img src="<?= $amb['image'] ?>" class="ambassador-banner" alt="Ambassador">
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#ambassadorCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#ambassadorCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>



    <!-- Foods Section Start -->
<section class="section-t-space">
    <div class="custom-container">
        <div class="title d-flex justify-content-between align-items-center">
            <h2>Most Popular Foods</h2>
            <a href="{{ url('/foods') }}">View All</a>
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

<?php
$has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
$has_done_kyc = has_done_kyc(Auth::user()->id);
$kycLevels = kyc_levels();
?>

{{-- 🔹 If user has NOT paid onboarding, show onboarding modal --}}
@if(!$has_done_kyc)


<button type="button" class="btn btn-warning d-none" id="showKycModal" data-bs-toggle="modal" data-bs-target="#kycModal"></button>

{{-- ✅ Clean KYC Modal --}}
<div class="modal fade" id="kycModal" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content pwa-modal">

            <!-- Clean Header -->
            <div class="modal-header pwa-header">
                <div class="w-100 text-center">
                    <div class="pwa-icon mb-3">🎯</div>
                    <h3 class="modal-title fw-bold mb-2 text-white">Choose Account Type</h3>
                    <p class="mb-0 pwa-subtitle">Select the verification level you wish to complete</p>
                </div>
            </div>

            <!-- Clean Body -->
            <div class="modal-body pwa-body">

                <div class="text-center mb-4">
                    <p class="pwa-text">Select an Account level below to see its details and start verification.</p>
                </div>

                <!-- Clean KYC Level Cards -->
                <div class="kyc-grid mb-4">
                    @foreach($kycLevels as $key => $level)
                        <div class="kyc-level-card" data-level="{{ $key }}">
                            <h5 class="kyc-title">{{ $level['title'] }}</h5>
                            <p class="kyc-subtitle">Click to view details</p>
                        </div>
                    @endforeach
                </div>

                <!-- KYC Details Section -->
                <div id="kyc-details" class="kyc-details-section">
                    <div class="kyc-selected-info">
                        <h4 id="kyc-title" class="selected-title"></h4>
                        <p id="kyc-desc" class="selected-desc"></p>
                    </div>

                    <form id="kyc-form" method="POST">
                        @csrf
                        <button type="submit" class="pwa-btn pwa-btn-primary w-100">
                             Proceed
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Auto-show KYC modal & dynamic behavior --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('showKycModal').click();

    const kycData = @json($kycLevels);
    const title = document.getElementById('kyc-title');
    const desc = document.getElementById('kyc-desc');
    const form = document.getElementById('kyc-form');
    const details = document.getElementById('kyc-details');

    document.querySelectorAll('.kyc-level-card').forEach(card => {
        card.addEventListener('click', () => {
            const data = kycData[card.dataset.level];
            title.textContent = data.title;
            desc.innerHTML = data.description;
            form.action = data.endpoint || "#";
            details.style.display = 'block';
            document.querySelectorAll('.kyc-level-card').forEach(c => c.classList.remove('active-card'));
            card.classList.add('active-card');
        });
    });
});
</script>



{{-- 🔹 If user paid onboarding but has NOT done KYC, show KYC modal --}}
@elseif(!$has_paid_onboarding)
    <!-- Hidden Trigger Button -->
<button type="button" class="btn btn-warning d-none" id="showOnboardingModal" data-bs-toggle="modal" data-bs-target="#onboardingModal"></button>

   {{-- ✅ Clean Onboarding Modal --}}
<div class="modal fade" id="onboardingModal" tabindex="-1" aria-labelledby="onboardingLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content pwa-modal">

            <!-- Clean Header -->
            <div class="modal-header pwa-header">
                <div class="w-100 text-center">
                    <div class="pwa-icon mb-3">🚀</div>
                    <h3 class="modal-title fw-bold mb-2 text-white">Complete Your Onboarding</h3>
                    <p class="mb-0 pwa-subtitle">Make a one-time payment to unlock full access</p>
                </div>
            </div>

            <!-- Clean Body -->
            <div class="modal-body pwa-body">
               <div class="text-center mb-4">
                   <h4 class="pwa-price mb-3">Pay only ₦1000 for account activation</h4>
                   <p class="pwa-text">Complete your KYC later to fully unlock all features.</p>
               </div>

               <div class="pwa-features mb-4">
                   <div class="feature-item">
                       <div class="feature-icon">✅</div>
                       <div class="feature-text">Full access to all basic platform features after activation</div>
                   </div>
                   <div class="feature-item">
                       <div class="feature-icon">✅</div>
                       <div class="feature-text">Option to complete KYC for advanced benefits</div>
                   </div>
               </div>

               <!-- Clean Payment Buttons -->
               <div class="pwa-buttons">
                   <a href="{{ route('pay.onboarding', ['gateway' => 'paystack']) }}"
                      class="pwa-btn pwa-btn-primary">
                        Pay with Paystack
                   </a>
                   <a href="{{ route('pay.onboarding', ['gateway' => 'fincra']) }}"
                      class="pwa-btn pwa-btn-secondary">
                       Pay with Fincra
                   </a>
               </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Auto-show onboarding modal --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById('showOnboardingModal').click();
    });
</script>
@endif

{{-- ✅ Clean PWA Styles --}}
<style>
/* Clean PWA Modal Styles */
.pwa-modal {
    border: none;
    border-radius: 20px;
    background: #ffffff;
    overflow: hidden;
}

.pwa-header {
    background: linear-gradient(135deg, #ff7e00, #ff5500);
    border: none;
    padding: 2rem 1.5rem;
}

.pwa-icon {
    font-size: 3rem;
    line-height: 1;
}

.pwa-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
}

.pwa-body {
    background: #ffffff;
    padding: 2rem 1.5rem;
}

.pwa-price {
    color: #ff5500;
    font-weight: 700;
    font-size: 1.3rem;
}

.pwa-text {
    color: #666;
    font-size: 1rem;
    line-height: 1.5;
}

.pwa-features {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.feature-item:last-child {
    margin-bottom: 0;
}

.feature-icon {
    font-size: 1.1rem;
    margin-right: 0.75rem;
    margin-top: 0.1rem;
    flex-shrink: 0;
}

.feature-text {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.4;
}

.pwa-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.pwa-btn {
    display: block;
    text-align: center;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    font-size: 1rem;
    cursor: pointer;
}

.pwa-btn-primary {
    background: #00b9f1;
    color: white;
}

.pwa-btn-primary:hover {
    background: #007ad9;
    color: white;
    transform: translateY(-1px);
}

.pwa-btn-secondary {
    background: #ff7e00;
    color: white;
}

.pwa-btn-secondary:hover {
    background: #ff5500;
    color: white;
    transform: translateY(-1px);
}

/* KYC Grid */
.kyc-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}

.kyc-level-card {
    flex: 1;
    min-width: 160px;
    max-width: 200px;
    padding: 1.25rem;
    border-radius: 12px;
    background: #f8f9fa;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    text-align: center;
}

.kyc-level-card:hover {
    background: #e9ecef;
    border-color: #ff7e00;
}

.kyc-level-card.active-card {
    background: #fff5f0;
    border-color: #ff7e00;
}

.kyc-title {
    color: #ff5500;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.kyc-subtitle {
    color: #666;
    font-size: 0.85rem;
    margin: 0;
}

.kyc-details-section {
    display: none;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}

.kyc-selected-info {
    text-align: center;
    margin-bottom: 1.5rem;
}

.selected-title {
    color: #ff5500;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.selected-desc {
    color: #666;
    margin: 0;
}

/* Mobile Responsive */
@media (max-width: 576px) {
    .pwa-header {
        padding: 1.5rem 1rem;
    }

    .pwa-body {
        padding: 1.5rem 1rem;
    }

    .pwa-icon {
        font-size: 2.5rem;
    }

    .kyc-grid {
        flex-direction: column;
    }

    .kyc-level-card {
        max-width: none;
    }
}

/* Remove all shadows globally for clean PWA look */
.modal-content {
    box-shadow: none !important;
}

.btn {
    box-shadow: none !important;
}

.btn:hover {
    box-shadow: none !important;
}
</style>

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
