@extends('user_new.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* (your existing CSS — unchanged) */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    :root {
        --primary-color: #d97706;
        --primary-dark: #92400e;
        --success-color: #000000;
        --success-dark: #1f2937;
        --danger-color: #ef4444;
        --danger-dark: #b91c1c;
        --warning-color: #f59e0b;
        --warning-dark: #b45309;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --bg-primary: #ffffff;
        --bg-secondary: #f9fafb;
        --bg-tertiary: #f3f4f6;
        --border-color: #e5e7eb;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }
    .main-content { padding: 2rem 0; min-height: 70vh; }
    .section-header { margin-bottom: 2rem; display:flex; justify-content:space-between; align-items:center; }
    .section-title { font-size: 1rem; font-weight:700; color:var(--text-primary); display:flex; align-items:center; gap:0.75rem; }
    .cart-count { background:var(--primary-color); color:white; border-radius:50%; width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; font-size:0.875rem; font-weight:600; }
    .clear-cart-btn { background:var(--danger-color); color:white; border:none; border-radius:var(--radius-lg); padding:0.75rem 1.25rem; font-weight:600; cursor:pointer; transition:all 0.2s ease; display:flex; align-items:center; gap:0.5rem; }
    .clear-cart-btn:hover { background:var(--danger-dark); transform:translateY(-1px); }
    .cart-container { display:grid; grid-template-columns:1fr 300px; gap:2rem; align-items:start; }
    .cart-items { background:var(--bg-primary); border-radius:var(--radius-xl); padding:1.5rem; box-shadow:var(--shadow-sm); border:1px solid var(--border-color); }
    .cart-item { display:flex; align-items:center; gap:1rem; padding:1.25rem; border:1px solid var(--border-color); border-radius:var(--radius-lg); margin-bottom:1rem; background:var(--bg-primary); transition:all 0.2s ease; }
    .cart-item:hover { box-shadow:var(--shadow-md); transform:translateY(-1px); }
    .cart-item:last-child { margin-bottom:0; }
    .item-image { width:80px; height:80px; background:var(--bg-tertiary); border-radius:var(--radius-md); display:flex; align-items:center; justify-content:center; color:var(--text-secondary); font-size:2rem; flex-shrink:0; }
    .item-details { flex:1; }
    .item-name { font-size:1.125rem; font-weight:600; color:var(--text-primary); margin-bottom:0.25rem; }
    .item-price { font-size:1rem; color:var(--primary-color); font-weight:600; margin-bottom:0.5rem; }
    .item-subtotal { font-size:0.875rem; color:var(--text-secondary); }
    .item-controls { display:flex; flex-direction:column; align-items:center; gap:0.75rem; }
    .qty-control { display:flex; align-items:center; border:1px solid var(--border-color); border-radius:var(--radius-md); overflow:hidden; background:var(--bg-primary); }
    .qty-btn { background:var(--bg-tertiary); border:none; padding:0.5rem 0.75rem; cursor:pointer; transition:all 0.2s ease; font-weight:600; color:var(--text-primary); width:2.5rem; height:2.5rem; display:flex; align-items:center; justify-content:center; }
    .qty-btn:hover:not(:disabled) { background:var(--border-color); }
    .qty-btn:disabled { opacity:0.5; cursor:not-allowed; }
    .qty-input { border:none; width:3.5rem; text-align:center; padding:0.5rem; font-weight:600; height:2.5rem; background:var(--bg-primary); }
    .qty-input:focus { outline:none; background:var(--bg-secondary); }
    .remove-btn { background:var(--danger-color); color:white; border:none; border-radius:var(--radius-md); padding:0.5rem; cursor:pointer; transition:all 0.2s ease; display:flex; align-items:center; justify-content:center; width:2.5rem; height:2.5rem; }
    .remove-btn:hover { background:var(--danger-dark); transform:scale(1.05); }
    .cart-summary { background:var(--bg-primary); border-radius:var(--radius-xl); padding:1.5rem; box-shadow:var(--shadow-sm); border:1px solid var(--border-color); height:fit-content; position:sticky; top:2rem; }
    .summary-title { font-size:1.25rem; font-weight:600; margin-bottom:1rem; color:var(--text-primary); }
    .summary-row { display:flex; justify-content:space-between; align-items:center; padding:0.75rem 0; border-bottom:1px solid var(--border-color); }
    .summary-row:last-child { border-bottom:none; font-weight:600; font-size:1.125rem; color:var(--text-primary); }
    .summary-label { color:var(--text-secondary); }
    .summary-value { font-weight:600; color:var(--text-primary); }
    .limit-info { background:var(--warning-color); color:white; padding:0.75rem; border-radius:var(--radius-md); margin:1rem 0; font-size:0.875rem; text-align:center; }
    .checkout-btn { width:100%; background:var(--success-color); color:white; border:none; border-radius:var(--radius-lg); padding:1rem; font-weight:600; cursor:pointer; transition:all 0.2s ease; display:flex; align-items:center; justify-content:center; gap:0.5rem; font-size:1rem; margin-top:1rem; }
    .checkout-btn:hover:not(:disabled) { background:var(--success-dark); transform:translateY(-1px); }
    .checkout-btn:disabled { background:var(--text-secondary); cursor:not-allowed; transform:none; }
    .empty-cart { text-align:center; padding:4rem 2rem; color:var(--text-secondary); }
    .empty-cart-icon { font-size:4rem; margin-bottom:1rem; opacity:0.5; }
    .empty-cart h2 { font-size:1.5rem; margin-bottom:0.5rem; color:var(--text-primary); }
    .empty-cart p { margin-bottom:2rem; font-size:1.1rem; }
    .continue-shopping-btn { background:black; color:white; border:none; border-radius:var(--radius-lg); padding:0.75rem 1.5rem; font-weight:600; cursor:pointer; transition:all 0.2s ease; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; }
    .continue-shopping-btn:hover { background:var(--primary-dark); transform:translateY(-1px); }
    .loading { opacity:0.6; pointer-events:none; }
    .spinner { width:1rem; height:1rem; border:2px solid transparent; border-top:2px solid currentColor; border-radius:50%; animation:spin 1s linear infinite; }
    @keyframes spin { 0% { transform:rotate(0deg); } 100% { transform:rotate(360deg); } }
    .alert { position:fixed; top:1rem; right:1rem; padding:1rem 1.5rem; border-radius:var(--radius-lg); color:white; font-weight:600; z-index:1000; transform:translateX(400px); transition:transform 0.3s ease; max-width:300px; }
    .alert.show { transform:translateX(0); }
    .alert.error { background:var(--danger-color); }
    .alert.success { background:var(--success-color); }
    @media (max-width:768px) {
        .cart-container { grid-template-columns:1fr; gap:1rem; }
        .section-header { flex-direction:column; align-items:flex-start; gap:1rem; }
        .cart-item { flex-direction:column; align-items:flex-start; gap:1rem; }
        .item-controls { flex-direction:row; width:100%; justify-content:space-between; }
        .section-title { font-size:1.75rem; }
    }
</style>

<div class="container">
    <div class="main-content">
        <div class="section-header">
            <h3 class="section-title">
                 Cart Items
                <span class="cart-count" id="cart-count">
                    {{ collect($carts)->sum(function($cart) { return collect($cart['items'])->sum('qty'); }) }}
                </span>
            </h3>
            @if(!empty($carts) && !empty($carts[0]['items']))
                <button class="clear-cart-btn" onclick="clearCart()">
                     Clear Cart
                </button>
            @endif
        </div>

        @if(empty($carts) || empty($carts[0]['items']))
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Add some delicious items to get started!</p>
                <a href="{{ route('user.packages') }}" class="continue-shopping-btn">
                    Browse Menu
                </a>
            </div>
        @else
            @php
                $cartItems = $carts[0]['items'];
                $totalAmount = collect($cartItems)->sum('total');
                $totalItems = collect($cartItems)->sum('qty');
                $limit = 20000;
            @endphp

            <div class="cart-container">
                <div class="cart-items">
                    @foreach($cartItems as $id => $item)
                        <div class="cart-item" id="cart-item-{{ $id }}">
                            <div class="item-image">
<img src="{{ asset(get_product_image($item['name'])) }}" width="80" height="80" alt="Product Image" />
                            </div>

                            <div class="item-details">
                                <h3 class="item-name">{{ $item['name'] }}</h3>
                                <div class="item-price">₦{{ number_format($item['price']) }}</div>
                                <div class="item-subtotal">
                                    Subtotal: ₦<span class="item-total">{{ number_format($item['total']) }}</span>
                                </div>
                            </div>

                            <div class="item-controls">
                                <div class="qty-control">
                                    <button class="qty-btn" onclick="updateQuantity({{ $id }}, {{ $item['qty'] - 1 }})"
                                            {{ $item['qty'] <= 1 ? 'disabled' : '' }}>-</button>
                                    <input type="number" class="qty-input" value="{{ $item['qty'] }}"
                                           min="1" max="50" id="qty-input-{{ $id }}"
                                           onchange="updateQuantity({{ $id }}, this.value)">
                                    <button class="qty-btn" onclick="updateQuantity({{ $id }}, {{ $item['qty'] + 1 }})">+</button>
                                </div>

                                <button class="remove-btn" onclick="removeFromCart({{ $id }})" title="Remove item">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <h3 class="summary-title">Order Summary</h3>

                    <div class="summary-row">
                        <span class="summary-label">Items ({{ $totalItems }})</span>
                        <span class="summary-value" id="items-total">₦{{ number_format($totalAmount) }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Delivery</span>
                        <span class="summary-value">₦0.00</span>
                    </div>

                    <div class="summary-row">
                        <span>Total</span>
                        <span id="grand-total">₦{{ number_format($totalAmount) }}</span>
                    </div>

                    <div  style="display:none;" class="limit-info">
                        Spending limit: ₦{{ number_format($limit) }}
                        <br>
                        Remaining: ₦{{ number_format($limit - $totalAmount) }}
                    </div>


<?php 
$has_done_kyc = has_done_kyc(Auth::user()->id);
$has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
$onboardingUrl = route('dashboard');
?>

<button 
    type="button"
    class="checkout-btn"
    onclick="handleCheckoutClick()"
>
    <span>Proceed to Checkout</span>
</button>

<script>
function handleCheckoutClick() {
    <?php if(!$has_done_kyc): ?>
        showSessionModal('error', 'Please complete your KYC before proceeding. Redirecting in 5 seconds...');
        setTimeout(function() {
            window.location.href = '<?php echo $onboardingUrl; ?>';
        }, 5000);
    <?php elseif(!$has_paid_onboarding): ?>
        showSessionModal('error', 'Please complete onboarding payment first. Redirecting in 5 seconds...');
        setTimeout(function() {
            window.location.href = '<?php echo $onboardingUrl; ?>';
        }, 5000);
    <?php else: ?>
        openCheckoutModal();
    <?php endif; ?>
}
</script>

                </div>
            </div>
        @endif
    </div>
</div>

<!-- ================== CHECKOUT MODAL (CLEANED) ================== -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h3 class="modal-title">Checkout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- Payment Method -->
        <div class="mb-3">
          <label class="form-label"><strong>Select Payment Method:</strong></label>
          <div class="mt-2">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentMethod" id="walletOption" value="wallet" checked>
              <label class="form-check-label" for="walletOption">Pay with Wallet</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentMethod" id="loanOption" value="loan">
              <label class="form-check-label" for="loanOption">Choose Installment</label>
            </div>
          </div>
        </div>

        <!-- Wallet Info & Address -->
        <div id="walletArea">
            <div class="" id="walletInfo_d">
                <!-- Wallet balance info will be populated here -->
            </div>
<div class="mb-3" id="deliveryAddressField">
    <label class="form-label fw-semibold">Delivery Address *</label>

    @php
        $addresses = json_decode(Auth::user()->home_address, true) ?? [];
    @endphp

    @if(empty($addresses))
        <!-- No saved addresses -->
        <div class="alert alert-warning d-flex align-items-center p-2 rounded-3">
            <i class="fas fa-map-marker-alt me-2 text-danger"></i>
            <span>You don’t have a saved delivery address.</span>
        </div>
        <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-sm rounded-pill">
            <i class="fas fa-plus me-1"></i> Add Delivery Address
        </a>
    @else
        <!-- Dropdown for saved addresses -->
        <select id="deliveryAddress" name="delivery_address" class="form-select rounded-3">
            @foreach($addresses as $address)
                <option value="{{ $address }}">{{ $address }}</option>
            @endforeach
        </select>
    @endif
</div>
        <div class="form-group" style="text-align: left; margin-top:10px; margin-bottom:10px;">
    <label>Phone Number</label>
    <input type="number" 
           class="form-control" 
           id="phone_number" 
           placeholder="Phone Number" />
</div>

        </div>

        <!-- Loan Fields -->
        <div id="loanFields" style="display:none;">

        <div class="form-group" style="text-align: left; margin-top:10px; margin-bottom:10px;">
    <label>Phone Number</label>
    <input type="number" 
           class="form-control" 
           id="phone_number2" 
           placeholder="Phone Number" />
</div>

          <!-- Bill Image Upload -->
          <div class="mb-3">
            <label class="form-label">Upload Utility Bill (contains home address) *</label>
            <input type="file" id="billImage" class="form-control" accept="image/*" />
            <small class="form-text text-muted">Upload a clear utility bill showing your home address.</small>
            <div id="billError" class="mt-1 text-danger" style="display:none;"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Bank Statement Slip (Not less than 6months)*</label>
            <input type="file" id="bankStatement" class="form-control" accept="image/*" />
            <div id="bankStatementError" class="mt-1 text-danger" style="display:none;"></div>
          </div>

          <!-- BVN Input -->
          <div class="mb-3">
            <label class="form-label">Enter BVN *</label>
            <input type="text" id="bvnInput" class="form-control" maxlength="11" placeholder="Enter your 11-digit BVN">
            <div id="creditScoreMessage" class="mt-2"></div>
          </div>

          <!-- Repayment Plan -->
          <div class="mb-3">
            <label class="form-label">Select Repayment Plan *</label>
            <select id="loanRepaymentPlan" class="form-select">
  <option value="" selected>Select Repayment Plan</option>
  <option value="semi-weekly">Semi-weekly (twice per week)</option>
  <option value="weekly">Weekly</option>
  <option value="bi-weekly">Bi-weekly (every 2 weeks)</option>
</select>

            <div id="paymentSplit" class=" mt-3" style="display:none;"></div>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Cancel
        </button>
        <button type="button" class="btn btn-primary" id="confirmCheckout" >
          Confirm Checkout
        </button>
      </div>

    </div>
  </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
/* ---------- Utilities & Globals ---------- */
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const DELIVERY_FEE = 1000;
const LIMIT = 20000;
const userBalance = parseFloat({{ Auth::user()->wallet_balance ?? 0 }}) || 0;

console.log('User balance:', userBalance); // Debug log

function showAlert(message, type = 'error') {
    const alert = document.createElement('div');
    alert.className = `custom-alert ${type}`;
    alert.textContent = message;

    Object.assign(alert.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        zIndex: '99999', // ensures it's always above modals
        padding: '12px 20px',
        borderRadius: '8px',
        color: '#fff',
        fontWeight: '500',
        fontSize: '15px',
        boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
        opacity: '0',
        transition: 'opacity 0.3s ease, transform 0.3s ease',
        transform: 'translateY(-10px)',
        pointerEvents: 'none'
    });

    // Background color depending on type
    if (type === 'success') alert.style.background = '#2ecc71';
    else if (type === 'warning') alert.style.background = '#f1c40f';
    else alert.style.background = '#e74c3c'; // error (default)

    document.body.appendChild(alert);

    // Animate in
    setTimeout(() => {
        alert.style.opacity = '1';
        alert.style.transform = 'translateY(0)';
    }, 100);

    // Animate out after 3s
    setTimeout(() => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            if (document.body.contains(alert)) document.body.removeChild(alert);
        }, 300);
    }, 3000);
}

function setLoading(element, isLoading) {
    if (!element) return;
    if (isLoading) {
        element.classList.add('loading');
        const spinner = element.querySelector('.spinner') || document.createElement('div');
        spinner.className = 'spinner';
        element.appendChild(spinner);
    } else {
        element.classList.remove('loading');
        const spinner = element.querySelector('.spinner');
        if (spinner) spinner.remove();
    }
}

/* ---------- Cart helpers ---------- */
function parseCurrencyToNumber(text) {
    if (!text) return 0;
    return parseFloat(text.toString().replace(/[^0-9.-]+/g,"")) || 0;
}

function calculateCartTotalFromDOM() {
    let total = 0;
    document.querySelectorAll('.cart-item').forEach((el) => {
        const priceText = el.querySelector('.item-price') ? el.querySelector('.item-price').textContent : '';
        const qtyInput = el.querySelector('.qty-input');
        const price = parseCurrencyToNumber(priceText);
        const qty = qtyInput ? parseInt(qtyInput.value || 0, 10) : 0;
        total += price * qty;
    });
    console.log('Cart total calculated:', total); // Debug log
    return total;
}

function refreshSummaryUI() {
    const total = calculateCartTotalFromDOM();
    document.getElementById('items-total').textContent = `₦${numberWithCommas(total)}`;
    document.getElementById('grand-total').textContent = `₦${numberWithCommas(total)}`;
    
    // Update modal validation if modal is open
    const checkoutModal = document.getElementById('checkoutModal');
    if (checkoutModal && checkoutModal.classList.contains('show')) {
        console.log('Modal is open, validating...'); // Debug log
        validateCurrentPaymentMethod();
    }
}

function numberWithCommas(x) {
    return x.toLocaleString(undefined, {maximumFractionDigits: 0});
}

/* ---------- DOM Elements ---------- */
let walletOption, loanOption, walletArea, walletInfo, deliveryAddressField;
let loanFields, bvnInput, creditScoreMessage, repaymentPlan, paymentSplit;
let confirmCheckoutBtn, billImage, billError , bankStatement, bankStatementError;

function initializeElements() {
    walletOption = document.getElementById('walletOption');
    loanOption = document.getElementById('loanOption');
    walletArea = document.getElementById('walletArea');
    walletInfo = document.getElementById('walletInfo_d');
    deliveryAddressField = document.getElementById('deliveryAddressField');
    loanFields = document.getElementById('loanFields');
    bvnInput = document.getElementById('bvnInput');
    creditScoreMessage = document.getElementById('creditScoreMessage');
    repaymentPlan = document.getElementById('loanRepaymentPlan');
    paymentSplit = document.getElementById('paymentSplit');
    confirmCheckoutBtn = document.getElementById('confirmCheckout');
    billImage = document.getElementById('billImage');
    bankStatement = document.getElementById('bankStatement');
    billError = document.getElementById('billError');
    bankStatementError = document.getElementById('bankStatementError');
}

/* ---------- Payment Method Functions ---------- */
function onPaymentMethodChange() {
    const method = document.querySelector("input[name='paymentMethod']:checked")?.value;
    console.log('Payment method changed to:', method); // Debug log
    
    if (method === 'wallet') {
        if (walletArea) walletArea.style.display = 'block';
        if (loanFields) loanFields.style.display = 'none';
        if (deliveryAddressField) deliveryAddressField.style.display = 'block';
    } else if (method === 'loan') {
        if (walletArea) walletArea.style.display = 'none';
        if (loanFields) loanFields.style.display = 'block';
        if (deliveryAddressField) deliveryAddressField.style.display = 'none';
    }
    
    // Always validate after method change
    setTimeout(() => {
        validateCurrentPaymentMethod();
    }, 100);
}

function validateCurrentPaymentMethod() {
    const method = document.querySelector("input[name='paymentMethod']:checked")?.value;
    console.log('Validating method:', method); // Debug log
    
    if (method === 'wallet') {
        updateWalletValidation();
    } else if (method === 'loan') {
        updateLoanValidation();
    }
}

/* ---------- Wallet Validation ---------- */
function updateWalletValidation() {
    console.log('Updating wallet validation...'); // Debug log
    
    if (!walletInfo) {
        console.error('walletInfo element not found');
        return false;
    }
    
    const total = calculateCartTotalFromDOM();
    const required = total + DELIVERY_FEE;
    const deliveryAddress = document.getElementById('deliveryAddress')?.value?.trim() || '';

    console.log('Total:', total, 'Required:', required, 'User balance:', userBalance, 'Address:', deliveryAddress); // Debug log

    if (total === 0) {
        walletInfo.innerHTML = `<strong>Wallet Balance:</strong> ₦${numberWithCommas(userBalance)}<br><small>Your cart is empty.</small>`;
        if (confirmCheckoutBtn) confirmCheckoutBtn.disabled = true;
        return false;
    }

    // Check address first
    if (!deliveryAddress) {
        walletInfo.innerHTML = `<strong>Wallet Balance:</strong> ₦${numberWithCommas(userBalance)}<br><small class="text-danger">❌ Please enter a delivery address.</small>`;
        if (confirmCheckoutBtn) confirmCheckoutBtn.disabled = true;
        return false;
    }

    // Check balance
    if (userBalance >= required) {
        walletInfo.innerHTML = `<strong>Wallet Balance:</strong> ₦${numberWithCommas(userBalance)}<br><small class="text-success">✅ You have enough balance to pay ₦${numberWithCommas(required)} (including ₦${numberWithCommas(DELIVERY_FEE)} delivery fee).</small>`;
        if (confirmCheckoutBtn) confirmCheckoutBtn.disabled = false;
        return true;
    } else {
        const shortfall = required - userBalance;
        walletInfo.innerHTML = `<strong>Wallet Balance:</strong> ₦${numberWithCommas(userBalance)}<br><small class="text-danger">❌ Insufficient balance. You need ₦${numberWithCommas(required)} but have ₦${numberWithCommas(userBalance)}. Short by ₦${numberWithCommas(shortfall)}.</small>`;
        if (confirmCheckoutBtn) confirmCheckoutBtn.disabled = true;
        return false;
    }
}

/* ---------- Loan Validation Functions ---------- */
function isValidBVN(bvn) {
    return /^\d{11}$/.test(bvn);
}

function clearLoanValidationMessages() {
    if (creditScoreMessage) creditScoreMessage.innerHTML = '';
    if (paymentSplit) {
        paymentSplit.style.display = 'none';
        paymentSplit.innerHTML = '';
    }
    if (billError) billError.style.display = 'none';
}

function checkBillFileSelected() {
    if (!billImage) return false;
    if (!billImage.files || billImage.files.length === 0) return false;
    return true;
}
function checkbankStatementFileSelected() {
    if (!bankStatement) return false;
    if (!bankStatement.files || bankStatement.files.length === 0) return false;
    return true;
}

function computeRepaymentSplit() {
    user_type = "user";
    const total = calculateCartTotalFromDOM();
    const plan = document.getElementById('loanRepaymentPlan')?.value || '';

    // Apply 10% interest
    const totalWithInterest = total + (total * 0.10);

    // Spread duration based on user type
    const spreadWeeks = (user_type === 'market_woman') ? 8 : 4;

    let periods, duration;

    // Different repayment periods based on plan
    if (plan === 'semi-weekly') {
        periods = spreadWeeks * 2; // 2 payments per week
        duration = `${spreadWeeks} weeks (semi-weekly)`;
    } else if (plan === 'weekly') {
        periods = spreadWeeks; // 1 payment per week
        duration = `${spreadWeeks} weeks (weekly)`;
    } else if (plan === 'bi-weekly') {
        periods = Math.ceil(spreadWeeks / 2); // 1 payment every 2 weeks
        duration = `${spreadWeeks} weeks (bi-weekly)`;
    }

    const perPayment = Math.ceil(totalWithInterest / periods);

    console.log('Repayment calculation:', { 
        user_type, plan, periods, perPayment, duration, total, totalWithInterest 
    });

    return { periods, perPayment, duration, total, totalWithInterest };
}


function updateLoanValidation() {
    console.log('Updating loan validation...'); // Debug log
    
    const bvnValue = bvnInput?.value || '';
    const bvnValid = isValidBVN(bvnValue);
    const billSelected = checkBillFileSelected();
    const repaymentPlanValue = repaymentPlan?.value || ''; // ✅ FIXED

    // Check BVN validity
    if (!bvnValid) {
        if (creditScoreMessage) {
            if (bvnValue.length > 0) {
                creditScoreMessage.innerHTML = `<span style="color:red">❌ BVN must be exactly 11 digits</span>`;
            } else {
                creditScoreMessage.innerHTML = `<span style="color:red">BVN Required</span>`;
            }
        }
        if (paymentSplit) paymentSplit.style.display = 'none';
        if (confirmCheckoutBtn) confirmCheckoutBtn.disabled = true;
        return false;
    } else {
        if (creditScoreMessage) {
            creditScoreMessage.innerHTML = `<span style="color:green"><i style="padding:2px; background:green; color:white; border-radius:5px;" class="fa fa-check"></i> BVN format is valid</span>`;
        }
    }
    
    // Handle bill validation
    if (!billSelected) {
        if (billError) {
            billError.style.display = 'block';
            billError.textContent = '❌ Please upload a utility bill image containing your home address.';
        }
        if (paymentSplit) paymentSplit.style.display = 'none';
        if (confirmCheckoutBtn) confirmCheckoutBtn.disabled = true;
        return false;
    } else {
        if (billError) billError.style.display = 'none';
    }

    // Handle repayment plan validation
    if (!repaymentPlanValue || repaymentPlanValue === '') {
        if (paymentSplit) paymentSplit.style.display = 'none';
        if (confirmCheckoutBtn) confirmCheckoutBtn.disabled = true;
        if (creditScoreMessage) {
            creditScoreMessage.innerHTML += `<br><span style="color:red">❌ Please select a repayment plan before proceeding</span>`;
        }
        console.log('❌ Repayment plan not selected');
        return false;
    }

    // ✅ All checks passed — show payment split
    const { periods, perPayment, duration, total, totalWithInterest } = computeRepaymentSplit();

    if (paymentSplit) {
        paymentSplit.style.display = 'block';
        paymentSplit.className = 'mt-3';
        paymentSplit.innerHTML = `
            <div><strong>Principal Amount:</strong> ₦${numberWithCommas(total)}</div>
            <div><strong>Service Charge (10%):</strong> ₦${numberWithCommas(totalWithInterest - total)}</div>
            <div><strong>Total Amount (with Service Charge):</strong> ₦${numberWithCommas(totalWithInterest)}</div>
            <div><strong>Payment Split:</strong> ${periods} payments of ₦${numberWithCommas(perPayment)} each</div>
            <div><strong>Duration:</strong> ${duration}</div>
            <div class="text-danger"><em>Note:</em> ₦1,000 processing fee applies and is non-refundable.</div>
        `;
    }

    if (confirmCheckoutBtn) confirmCheckoutBtn.disabled = false;
    return true;
}


/* ---------- Event Listeners ---------- */
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing...'); // Debug log
            computeRepaymentSplit();

    // Initialize elements
    initializeElements();
    
    // Store original qtys
    document.querySelectorAll('.qty-input').forEach(input => {
        input.dataset.original = input.value;
    });

    // Update summary initially
    refreshSummaryUI();

    // Payment method change listeners
    document.querySelectorAll("input[name='paymentMethod']").forEach(radio => {
        radio.addEventListener("change", onPaymentMethodChange);
    });

    // Delivery address change listener for wallet validation
    const deliveryAddressInput = document.getElementById('deliveryAddress');
    if (deliveryAddressInput) {
        deliveryAddressInput.addEventListener('input', function() {
            const method = document.querySelector("input[name='paymentMethod']:checked")?.value;
            if (method === 'wallet') {
                updateWalletValidation();
            }
        });
    }

    // Update summary when qty changes locally
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('input', function() {
            let v = parseInt(this.value, 10) || 1;
            if (v < 1) v = 1;
            if (v > 50) v = 50;
            this.value = v;
            refreshSummaryUI(); // This will trigger validation if modal is open
        });
    });

    // BVN input validation
    if (bvnInput) {
        bvnInput.addEventListener('input', function() {
            updateLoanValidation();
        });
    }

    // Repayment plan change
    if (repaymentPlan) {
        repaymentPlan.addEventListener('change', function() {
            updateLoanValidation();
        });
    }

    // Bill image change
    if (billImage) {
        billImage.addEventListener('change', function() {
            updateLoanValidation();
        });
    }

    // Confirm checkout handler
    if (confirmCheckoutBtn) {
        confirmCheckoutBtn.addEventListener('click', async () => {
            const address = document.getElementById('deliveryAddress')?.value?.trim() || '';
            const phone_number = document.getElementById('phone_number')?.value?.trim() || '';
            const phone_number2 = document.getElementById('phone_number2')?.value?.trim() || '';
            const payment = document.querySelector("input[name='paymentMethod']:checked")?.value;
            const cartItems = [];
            
            document.querySelectorAll('.cart-item').forEach((el) => {
                const id = el.id.split('-')[2];
                const name = el.querySelector('.item-name')?.textContent?.trim() || '';
                const priceText = el.querySelector('.item-price')?.textContent || '';
                const price = parseCurrencyToNumber(priceText);
                const qty = parseInt(el.querySelector('.qty-input')?.value || 0, 10);
                cartItems.push({ id: parseInt(id,10), name, qty, price, total: price * qty });
            });

            if (cartItems.length === 0) {
                showAlert("Your cart is empty", "error");
                return;
            }

            const totalAmount = cartItems.reduce((s,i) => s + i.total, 0);

            // Final validation before submission
            if (payment === 'wallet') {
                const required = totalAmount + DELIVERY_FEE;
                if (userBalance < required) {
                    showAlert(`Insufficient balance. You need ₦${numberWithCommas(required)} but have ₦${numberWithCommas(userBalance)}`, "error");
                    return;
                }
                if (!address) {
                    showAlert('Please enter a delivery address', 'error');
                    return;
                }
               if (!phone_number || !/^\d{11}$/.test(phone_number.trim())) {
    showAlert('Please enter a valid 11-digit phone number', 'error');
    return;
}


            } else {
                if (!checkBillFileSelected()) {
                    showAlert('Please upload a utility bill containing your address', 'error');
                    return;
                }
                
                if (!isValidBVN(bvnInput?.value || '')) {
                    showAlert('BVN must be exactly 11 digits', 'error');
                    return;
                }

if (!phone_number2 || !/^\d{11}$/.test(phone_number2.trim())) {
    showAlert('Please enter a valid 11-digit phone number', 'error');
    return;
}



            }

            // Prepare FormData
            const formData = new FormData();
            formData.append('items', JSON.stringify(cartItems));
            formData.append('total_amount', totalAmount);
            formData.append('address', address);
            if (phone_number) {
    formData.append('phone_number', phone_number);
} else if (phone_number2) {
    formData.append('phone_number', phone_number2);
}

            formData.append('payment_method', payment);
             const { periods, perPayment, duration, total } = computeRepaymentSplit();

            if (payment === 'loan') {
                formData.append('bvn', bvnInput?.value || '');
                formData.append('repayment_plan', repaymentPlan?.value || '');
                formData.append('repayment_amount', perPayment);
                if (billImage && billImage.files.length > 0) {
                    formData.append('bill_image', billImage.files[0]);
                }
                if (bankStatement && bankStatement.files.length > 0) {
                    formData.append('bankStatement', bankStatement.files[0]);
                }
            }

console.log(formData);

            confirmCheckoutBtn.disabled = true;
            setLoading(confirmCheckoutBtn, true);

            try {
                const response = await fetch("{{ route('checkout') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Accept": "application/json"
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showAlert(result.message, "success");
                    if (result.order && result.order.order_number) {
                        window.location.href = `/orders/${result.order.order_number}`;
                    } else {
                        setTimeout(() => window.location.reload(), 1000);
                    }
                } else {
                    // Hide checkout modal first

                    const checkoutModal = document.getElementById('checkoutModal');
if (checkoutModal) checkoutModal.style.display = 'none';

const modalBackdrop = document.querySelector('.modal-backdrop');
if (modalBackdrop) modalBackdrop.style.display = 'none';

// Now show the error modal
showSessionModal('error', result.message);

confirmCheckoutBtn.disabled = false;

                    }
            } catch (error) {
                console.error('Checkout error:', error);
                showAlert('Failed to place order. Please try again.', "error");
                confirmCheckoutBtn.disabled = false;
            } finally {
                setLoading(confirmCheckoutBtn, false);
            }
        });
    }

    // Set initial state
    onPaymentMethodChange();
});

/* ---------- Modal Event Handlers ---------- */
// Listen for modal show event
document.getElementById('checkoutModal')?.addEventListener('shown.bs.modal', function() {
    console.log('Modal shown, triggering validation...'); // Debug log
    setTimeout(() => {
        validateCurrentPaymentMethod();

    }, 200);
});

// Listen for modal hide event
document.getElementById('checkoutModal')?.addEventListener('hidden.bs.modal', function() {
    console.log('Modal hidden, clearing validations...'); // Debug log
    clearLoanValidationMessages();
});

/* ---------- Cart Action Functions ---------- */

async function updateQuantity(id, newQty) {
    newQty = parseInt(newQty);
    if (isNaN(newQty) || newQty < 1 || newQty > 50) {
        showAlert('Invalid quantity. Must be between 1 and 50.', 'error');
        const qtyInput = document.getElementById(`qty-input-${id}`);
        if (qtyInput) qtyInput.value = qtyInput.dataset.original || 1;
        return;
    }

    const cartItem = document.getElementById(`cart-item-${id}`);
    setLoading(cartItem, true);

    try {
        const response = await fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({ id, qty: newQty })
        });

        const result = await response.json();

        if (result.success) {
            showAlert(result.message, "success");
            setTimeout(() => window.location.reload(), 800);
        } else {
            showAlert(result.message, "error");
            const qtyInput = document.getElementById(`qty-input-${id}`);
            if (qtyInput) qtyInput.value = qtyInput.dataset.original || 1;
        }
    } catch (error) {
        console.error('Error updating cart:', error);
        showAlert('Failed to update cart. Please try again.', 'error');
    } finally {
        setLoading(cartItem, false);
    }
}

async function removeFromCart(id) {
    const confirmation = await Swal.fire({
        title: 'Remove Item?',
        text: 'Are you sure you want to remove this item from your cart?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff8c00',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'Cancel'
    });

    if (!confirmation.isConfirmed) return;

    const cartItem = document.getElementById(`cart-item-${id}`);
    setLoading(cartItem, true);

    try {
        const response = await fetch("{{ route('cart.remove') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({ id })
        });

        const result = await response.json();

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Removed!',
                text: result.message,
                timer: 1200,
                showConfirmButton: false
            });

            if (cartItem) {
                cartItem.style.transition = 'all 0.4s ease';
                cartItem.style.transform = 'translateX(-100%)';
                cartItem.style.opacity = '0';
            }

            setTimeout(() => window.location.reload(), 600);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: result.message
            });
        }
    } catch (error) {
        console.error('Error removing item:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to remove item. Please try again.'
        });
    } finally {
        setLoading(cartItem, false);
    }
}
async function clearCart() {
    const confirmation = await Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to clear your entire cart?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff8c00',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, clear it!',
        cancelButtonText: 'Cancel'
    });

    if (!confirmation.isConfirmed) return;

    const clearBtn = document.querySelector('.clear-cart-btn');
    setLoading(clearBtn, true);

    try {
        const response = await fetch("{{ route('cart.clear') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json"
            },
            body: JSON.stringify({})
        });

        const result = await response.json();

        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Cleared!',
                text: result.message,
                timer: 1500,
                showConfirmButton: false
            });
            window.location.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: result.message
            });
        }
    } catch (error) {
        console.error('Error clearing cart:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Failed to clear cart. Please try again.'
        });
    } finally {
        setLoading(clearBtn, false);
    }
}

/* ---------- Open Modal Function ---------- */
function openCheckoutModal() {
    const total = calculateCartTotalFromDOM();
    {{-- if (total + DELIVERY_FEE > LIMIT) {
        showAlert("Cannot checkout: Amount exceeds limit", "error");
        return;
    }
     --}}
    console.log('Opening checkout modal...'); // Debug log
    
    // Refresh UI before opening
    refreshSummaryUI();
    clearLoanValidationMessages();
    
    // Initialize elements in case they weren't ready before
    initializeElements();
    
    const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    modal.show();
}
</script>
@endsection