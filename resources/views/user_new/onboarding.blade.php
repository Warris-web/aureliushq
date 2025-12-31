@extends('user_new.app')

@section('content')

<style>
/* ======= GENERAL MODAL ======= */
.pwa-modal {
    border: none;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* ======= HEADER ======= */
.pwa-header {
    background: linear-gradient(135deg, #FF6600, #000000);
    padding: 2rem 1.5rem;
    color: white;
}
.pwa-icon { font-size: 3rem; }
.pwa-subtitle { color: rgba(255,255,255,0.85); font-size: 1rem; }

/* ======= BODY ======= */
.pwa-body { padding: 2rem 1.5rem; background: #fff; }
.pwa-text { color: #333; font-size: 0.95rem; line-height: 1.6; }

/* ======= SELECT FIELDS ======= */
.form-control {
    border-radius: 10px;
    border: 1px solid #ddd;
    padding: 10px;
}
.form-control:focus {
    border-color: #FF6600;
    box-shadow: 0 0 4px rgba(255,102,0,0.4);
}

/* ======= KYC CARDS ======= */
.kyc-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
}
.kyc-level-card {
    min-width: 160px;
    max-width: 200px;
    padding: 1.25rem;
    border-radius: 14px;
    background: #f9f9f9;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.05);
}
.kyc-level-card:hover {
    background: #fffefb;
    border-color: #FF6600;
    transform: translateY(-3px);
}
.kyc-level-card.active-card {
    background: #fff2e6;
    border-color: #FF6600;
}
.kyc-title { color: #FF6600; font-weight: 600; }

/* ======= KYC DETAILS ======= */
.kyc-details-section {
    display: none;
    margin-top: 1.5rem;
    border-top: 1px solid #ececec;
    padding-top: 1.5rem;
}
.selected-title { color: #FF6600; font-weight: 700; }
.selected-desc { color: #555; }

/* ======= BUTTONS ======= */
.pwa-btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all .3s ease;
    min-width: 160px;
}

.pwa-btn-primary {
    background: #FF6600;
    color: #fff;
}
.pwa-btn-primary:hover {
    background: #e65a00;
}

.pwa-btn-secondary {
    background: #000;
    color: #fff;
}
.pwa-btn-secondary:hover {
    background: #222;
}

.pwa-btn-back {
    border: 2px solid #FF6600;
    background: transparent;
    color: #FF6600;
}
.pwa-btn-back:hover {
    background: #FF6600;
    color: #fff;
}

/* RESPONSIVE */
@media (max-width: 576px) {
    .kyc-grid { flex-direction: column; }
}


/* Modal Wrapper Improvements */
.pwa-modal {
    background: #ffffff;
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid #eee;
}



.pwa-icon {
    font-size: 2.4rem;
}

/* Body */
.pwa-body {
    padding: 20px;
}

.pwa-text {
    color: #666;
    font-size: 0.95rem;
}

/* Dropdowns */
.form-select {
    border-radius: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    transition: 0.3s;
}

.form-select:focus {
    border-color: #005bea;
    box-shadow: 0 0 4px rgba(0, 91, 234, 0.4);
}

/* KYC Grid */
.kyc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 15px;
}

.kyc-level-card {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
    border: 1px solid #ececec;
}

.kyc-level-card:hover {
    background: #e9f3ff;
    border-color: #0095ff;
    transform: translateY(-2px);
}

.kyc-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.kyc-subtitle {
    font-size: 0.85rem;
    color: #777;
}

/* Selected Details Section */
.kyc-details-section {
    background: #f1f9ff;
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #d7ecff;
}

.selected-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #005bea;
}

.selected-desc {
    color: #555;
    font-size: 0.95rem;
    margin-bottom: 20px;
}

/* Buttons */
.pwa-btn {
    padding: 12px;
    border-radius: 10px;
    font-weight: 600;
    text-align: center;
    border: none;
    cursor: pointer;
    display: inline-block;
    transition: 0.3s;
}

.pwa-btn-primary {
    background: darkorange;
    color: #fff;
}

.pwa-btn-primary:hover {
    background: #0044b2;
}

.pwa-btn-secondary {
    background: black;
    color: #fff;
}

.pwa-btn-secondary:hover {
    background: #d6dadd;
}

/* Responsive Fix */
@media (max-width: 576px) {
    .kyc-grid {
        grid-template-columns: 1fr 1fr;
    }
}
</style>
@php
    $has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
    $has_done_kyc = has_done_kyc(Auth::user()->id);
    $kycLevels = kyc_levels();
@endphp

<div class="container my-4">

    {{-- ========================= KYC SECTION ========================= --}}
    @if(!$has_done_kyc)
    <div class="pwa-modal shadow-sm mb-4">
        <!-- Header -->
        <div class="pwa-header text-center">
            <div class="pwa-icon mb-3">🎯</div>
            <h3 class="fw-bold mb-2 text-white">Choose Location</h3>
            <p class="mb-0 pwa-subtitle">Select your state and LGA to continue</p>
        </div>

        <!-- Body -->
        <div class="pwa-body">

            <!-- Select State -->
            <div class="mb-1">
                <label class="fw-semibold text-white">Select Operational State</label>
                <select id="state-select" class="form-control">
                    <option value="">-- Choose a state --</option>
                    @foreach($states as $state)
                        <option value="{{ $state->state_id ?? $state['state_id'] }}">
                            {{ $state->state_name ?? $state['state_name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Select LGA (hidden by default) -->
            <div class="mb-1" id="lga-container" style="display:none;">
                <label class="fw-semibold text-white">Select LGA</label>
                <select id="lga-select" class="form-control"></select>
            </div>

            <!-- KYC Section (hidden initially) -->
            <div id="kyc-section" style="display:none;">
                <div class="text-center mb-4">
                    <p class="pwa-text">Select an account level below to see its details and start verification.</p>
                </div>

                <div class="kyc-grid mb-4">
                    @foreach($kycLevels as $key => $level)
                        <div class="kyc-level-card" data-level="{{ $key }}">
                            <h5 class="kyc-title">{{ $level['title'] }}</h5>
                            <p class="kyc-subtitle">Click to view details</p>
                        </div>
                    @endforeach
                </div>

                <div id="kyc-details" class="kyc-details-section">
                    <div class="kyc-selected-info">
                        <h4 id="kyc-title" class="selected-title"></h4>
                        <p id="kyc-desc" class="selected-desc"></p>
                    </div>

<form id="kyc-form" method="POST">
                        @csrf
                        <input type="hidden" name="state" id="selected-state">
                        <input type="hidden" name="lga" id="selected-lga">
                        <input type="hidden" name="package" id="selected-level">

                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 6px; width: 100%;">
  <a href="{{ route('dashboard') }}"
     style="flex: 1; max-width: 90px; font-size: 13px; padding: 5px 8px; text-align: center; background: #ccc; color: #000; border-radius: 6px; text-decoration: none; font-weight:700;">
     ← Back
  </a>
  <button type="submit"
     style="flex: 1; max-width: 90px; font-size: 13px; padding: 5px 8px; background: #ff8c00; color: #fff; border: none; border-radius: 6px; cursor: pointer;font-weight:700;">
     Proceed →
  </button>
</div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    @endif

    {{-- ========================= ONBOARDING SECTION ========================= --}}
    @if(!$has_paid_onboarding && $has_done_kyc)




    <!-- 🌟 Updated Onboarding Card (Full Details + New Design) -->
<div class="onboarding-card border-0 shadow-lg mx-auto my-4"
     style="max-width:450px; border-radius:25px; overflow:hidden; background:#fff;">

    <!-- 🌈 Gradient Header -->
    <div class="text-center d-block py-4"
         style="background:linear-gradient(135deg,#ff8c00,#ff6a00); background-size:300% 300%; animation:gradientFlow 6s ease-in-out infinite;">
        <h3 class="fw-bold mb-1 text-white">🚀 Complete Your Onboarding</h3>
        <p class="mb-0 text-white-50" style="font-size:0.95rem;">
            Make a one-time payment to unlock full access
        </p>
    </div>

    <!-- 💰 Body -->
    <div class="text-center px-4 py-4" style="background:#fffaf5;">
        <p class="fw-bold mb-3" style="color:#ff8c00; font-size:1.1rem;">
💳 Pay only ₦1000 for account activation.            <br><span style="font-size:0.9rem; color:#555;">Make a one-time payment to activate your account and access all basic features.</span>
        </p>

        <!-- 🌟 Features (FULL OLD CONTENT) -->
        <ul class="list-unstyled mb-4 text-start mx-auto"
            style="max-width:380px; font-size:0.9rem; color:#333;">
            <li class="mb-2">✅ Full access to all basic platform features after activation</li>

            <li class="mb-2">✅ Access the Marketplace to explore and order foodstuffs easily</li>
            <li class="mb-2">✅ Instant Virtual Wallet activation for seamless deposits and purchases</li>
            <li class="mb-2">✅ Referral rewards — earn bonuses for every successful invite</li>
            <li class="mb-2">✅ Secure transactions protected by top-tier verified gateway partners</li>
        </ul>

        <!-- Payment Buttons (SIDE-BY-SIDE ALWAYS) -->
        <div class="payment-buttons d-flex justify-content-center">
            <a href="{{ route('pay.onboarding', ['gateway' => 'paystack']) }}" class="paystack-btn">
                Pay with Paystack
            </a>
            <a href="{{ route('pay.onboarding', ['gateway' => 'fincra']) }}" class="fincra-btn">
                Pay with Fincra
            </a>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ url('/dashboard') }}" class="text-dark fw-semibold"
               style="text-decoration:none; font-size:0.9rem; opacity:0.8;">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>


<style>
@keyframes gradientFlow {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}

/* Button container */
.payment-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
}

/* Base button */
.payment-buttons a {
    display: inline-block;
    text-align: center;
    font-weight: 600;
    font-size: 1rem;
    padding: 10px 20px;
    border-radius: 40px;
    text-decoration: none;
    transition: all 0.3s ease;
    width: 48%; /* Stay side-by-side on all screens */
    min-width: 120px;
}

/* Paystack button */
.paystack-btn {
    background: linear-gradient(135deg, #ff8c00, #e67e00);
    color: #fff;
    box-shadow: 0 4px 10px rgba(255,140,0,0.3);
}
.paystack-btn:hover {
    background: linear-gradient(135deg, #ffa733, #ff8c00);
    box-shadow: 0 6px 14px rgba(255,140,0,0.45);
}

/* Fincra button */
.fincra-btn {
    background: #fff;
    color: #222;
    border: 2px solid #ff8c00;
}
.fincra-btn:hover {
    background: #fff5eb;
}

/* Force both buttons to stay side-by-side on mobile */
@media (max-width: 576px) {
    .payment-buttons {
        gap: 10px;
    }
    .payment-buttons a {
        width: 48% !important; /* Never stack */
        font-size: 0.9rem;
        padding: 10px 10px;
    }
}
</style>

    @endif
</div>

{{-- ========================= SCRIPT ========================= --}}
<script>
document.getElementById('state-select').addEventListener('change', function () {
    let state = this.value;
    if (!state) return;

    document.getElementById('selected-state').value = state;

    fetch(`/get-lgas/${state}`)
        .then(response => response.json())
        .then(data => {
            let lgas = data.lgas || [];
            let lgaSelect = document.getElementById('lga-select');
            lgaSelect.innerHTML = '<option value="">-- Select LGA --</option>';
            lgas.forEach(lga => lgaSelect.innerHTML += `<option value="${lga}">${lga}</option>`);
            document.getElementById('lga-container').style.display = 'block';
        });
});

document.getElementById('lga-select').addEventListener('change', function () {
    document.getElementById('selected-lga').value = this.value;
    if (this.value) {
        document.getElementById('kyc-section').style.display = 'block';
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const kycData = @json($kycLevels);
    const title = document.getElementById('kyc-title');
    const desc = document.getElementById('kyc-desc');
    const form = document.getElementById('kyc-form');
    const details = document.getElementById('kyc-details');

    document.querySelectorAll('.kyc-level-card').forEach(card => {
        card.addEventListener('click', () => {
            const level = card.dataset.level;
            const data = kycData[level];
            title.textContent = data.title;
            desc.innerHTML = data.description;
            form.action = data.endpoint || "#";
            document.getElementById('selected-level').value = level;
            details.style.display = 'block';
            document.querySelectorAll('.kyc-level-card').forEach(c => c.classList.remove('active-card'));
            card.classList.add('active-card');
        });
    });
});
</script>
@endsection
