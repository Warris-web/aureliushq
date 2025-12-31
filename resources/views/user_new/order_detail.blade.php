@extends('user_new.app')

@section('content')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4338ca;
        --success-color: #10b981;
        --success-dark: #059669;
        --danger-color: #ef4444;
        --danger-dark: #dc2626;
        --warning-color: #f59e0b;
        --warning-dark: #d97706;
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

    .order-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        background: var(--bg-primary);
        padding: 2rem;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .order-title {
        {{-- font-size: 2rem; --}}
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .order-number {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-lg);
        font-size: 0.875rem;
        font-weight: 600;
    }

    .back-btn {
        background: var(--text-secondary);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .back-btn:hover {
        background: var(--text-primary);
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }


    .order-details {
        background: var(--bg-primary);
        border-radius: var(--radius-xl);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .order-management {
        background: var(--bg-primary);
        border-radius: var(--radius-xl);
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        position: sticky;
        top: 2rem;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Order Status */
    .status-display {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 1rem;
        text-transform: capitalize;
        margin-bottom: 1.5rem;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-preparing { background: #e0e7ff; color: #3730a3; }
    .status-ready { background: #dcfce7; color: #166534; }
    .status-delivered { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    /* Order Info Grid */
    .info-grid {
        {{-- display: grid; --}}
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }

    .info-label {
        font-weight: 600;
        color: var(--text-secondary);
    }

    .info-value {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Order Items */
    .order-items {
        margin-bottom: 2rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        margin-bottom: 1rem;
        background: var(--bg-primary);
        transition: all 0.2s ease;
    }

    .order-item:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }

    .order-item:last-child {
        margin-bottom: 0;
    }

    .item-icon {
        width: 60px;
        height: 60px;
        background: var(--bg-tertiary);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--text-secondary);
        flex-shrink: 0;
    }

    .item-details {
        flex: 1;
        margin-left: 1rem;
    }

    .item-name {
        font-weight: 600;
        font-size: 1.125rem;
        margin-bottom: 0.25rem;
        color: var(--text-primary);
    }

    .item-meta {
        font-size: 0.875rem;
        color: var(--text-secondary);
        display: flex;
        gap: 1rem;
    }

    .item-total {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--primary-color);
    }

    .total-summary {
        border-top: 2px solid var(--border-color);
        padding-top: 1.5rem;
        text-align: right;
    }

    .total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    /* Management Panel */
    .management-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
    }

    .management-section:last-child {
        margin-bottom: 0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .section-icon {
        font-size: 1.25rem;
    }

    .section-label {
        font-weight: 600;
        color: var(--text-primary);
    }

    .current-value {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-left: auto;
    }

    /* Form Controls */
    .form-group {
        margin-bottom: 1rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 1rem;
        transition: all 0.2s ease;
        background: var(--bg-primary);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .radio-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--bg-primary);
    }

    .radio-option:hover {
        border-color: var(--primary-color);
        background: rgba(99, 102, 241, 0.05);
    }

    .radio-option.selected {
        border-color: var(--primary-color);
        background: rgba(99, 102, 241, 0.1);
    }

    .radio-input {
        margin: 0;
    }

    .radio-label {
        font-weight: 600;
        color: var(--text-primary);
        flex: 1;
    }

    .radio-description {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 2rem;
    }

    .update-btn {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: var(--radius-lg);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-delivery {
        background: var(--success-color);
        color: white;
    }

    .btn-delivery:hover {
        background: var(--success-dark);
        transform: translateY(-1px);
    }

    .btn-payment {
        background: var(--warning-color);
        color: white;
    }

    .btn-payment:hover {
        background: var(--warning-dark);
        transform: translateY(-1px);
    }

    .btn-fee {
        background: var(--primary-color);
        color: white;
    }

    .btn-fee:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    /* Loading & Success States */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Alerts */
    .alert {
        position: fixed;
        top: 1rem;
        right: 1rem;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        color: white;
        font-weight: 600;
        z-index: 1000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 300px;
    }

    .alert.show {
        transform: translateX(0);
    }

    .alert.error {
        background: var(--danger-color);
    }

    .alert.success {
        background: var(--success-color);
    }

    /* Notes Display */
    .notes-section {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .notes-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .notes-content {
        color: var(--text-secondary);
        font-style: italic;
        line-height: 1.5;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .order-content {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-title {
            font-size: 1.5rem;
        }

        .order-management {
            position: static;
        }

        .item-meta {
            flex-direction: column;
            gap: 0.25rem;
        }
    }
</style>

<div class="container">
    <!-- Order Header -->
    <div class="order-header">
        <div>
        <div class="mb-2">
        <a href="{{ route('user.orders') }}" class="back-btn">
    <i class="fas fa-arrow-left"></i> Back to Orders
</a></div>
            <h3 class="order-title">
                Order Management
                <span class="order-number">{{ $order->order_number }}</span>
            </h1>
            <div class="status-display status-{{ $order->status }}">
                @switch($order->status)
                    @case('pending')  @break
                    @case('confirmed')  @break
                    @case('preparing')  @break
                    @case('ready')  @break
                    @case('delivered')  @break
                    @case('cancelled')  @break
                @endswitch
                {{ ucfirst($order->status) }}
            </div>

        </div>


    </div>

    <div class="order-content">
        <!-- Order Details -->
        <div class="order-details">
            <h2 class="section-title"> Order Details</h2>

            <!-- Order Info -->
            <div class="info-grid">

                <div class="info-item">
                    <span class="info-label">Order Date</span>
                    <span class="info-value">{{ $order->created_at->format('M d, Y - h:i A') }}</span>
                </div>
                {{-- <div class="info-item">
                    <span class="info-label">Customer</span>
                    <span class="info-value">{{ $order->user->name ?? 'N/A' }}</span>
                </div> --}}
                <div class="info-item">
                    <span class="info-label">Payment Type</span>
                    @if($order->payment_method ==='loan')
                                          <span class="info-value">Installment</span>

                    @else
                    <span class="info-value">{{ $order->payment_method ? ucfirst($order->payment_method) : 'Not Set' }}</span>

                    @endif
                </div>
                @if(!empty($order->delivery_address))
    <div class="info-item">
        <span class="info-label">Home Address</span>
        <span class="info-value">{{ ucfirst($order->delivery_address) }}</span>
    </div>
@endif

                <div class="info-item">
                    <span class="info-label">Mandatory Fee</span>
                    <span class="info-value">{{ $order->has_paid_delivery_fee =='yes' ? 'Yes' : 'No' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Delivered</span>
                    <span class="info-value">
                        {{ $order->delivered_at ? $order->delivered_at->format('M d, Y - h:i A') : 'Not Delivered' }}
                    </span>
                </div>



    @if($order->repayment_amount)
    <div class="info-item">
        <span class="info-label">Repayment Amount</span>
        <span class="info-value">₦{{ number_format($order->repayment_amount) }}</span>
    </div>
    @endif
            </div>



            <!-- Order Items -->
            <div class="order-items">
                <h3 class="section-title"> Ordered Items</h3>

                @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-icon">
                        <img src="{{ asset(get_product_image($item['name'])) }}" width="80" height="80" alt="Product Image" />

                        </div>

                        <div class="item-details">
                            <h4 class="item-name">{{ $item['name'] }}</h4>
                            <div class="item-meta">
                                <span>Qty: {{ $item['qty'] }}</span>
                                <span>Price: ₦{{ number_format($item['price']) }}</span>
                            </div>
                        </div>

                        <div class="item-total">₦{{ number_format($item['total']) }}</div>
                    </div>
                @endforeach

                <div class="total-summary">
                    <div class="total-amount">
                        Total: ₦{{ number_format($order->total_amount) }}
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($order->notes)
                <div class="notes-section">
                    <h4 class="notes-title"> Special Notes</h4>
                    <div class="notes-content">{{ $order->notes }}</div>
                </div>
            @endif
        </div>

    </div>
</div>


<div class="modal fade" id="processingFeeModal" tabindex="-1" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content rounded-3 shadow">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Processing Fee Required</h5>
      </div>
      <div class="modal-body text-center">
        <p>You must pay a <strong>₦1,000 processing fee</strong> to continue.</p>

        <div class="form-check text-start my-2">
          <input class="form-check-input" type="radio" name="gateway" id="paystackOption" value="paystack" checked>
          <label class="form-check-label" for="paystackOption">Pay with Paystack</label>
        </div>
        <div class="form-check text-start">
          <input class="form-check-input" type="radio" name="gateway" id="fincraOption" value="fincra">
          <label class="form-check-label" for="fincraOption">Pay with Fincra</label>
        </div>
        <div class="form-check text-start">
          <input class="form-check-input" type="radio" name="gateway" id="walletOption" value="wallet">
          <label class="form-check-label" for="walletOption">Pay with Aurelius Wallet</label>
        </div>
        <div id="walletPaymentInfo" class="alert alert-info mt-3" style="display:none;">
          <i class="fas fa-info-circle"></i> <strong>Aurelius Wallet Disabled for Instalments</strong><br>
          Wallet funds are reserved only for outright purchases. For instalment payments, please use <strong>Paystack</strong> or <strong>Fincra</strong>.
        </div>
      </div>
      <div class="modal-footer">
        <button id="proceedPaymentBtn" style="background:darkorange; color:white;" class="btn btn-warning w-100">Proceed to Payment</button>
      </div>
    </div>
  </div>
</div>


<script>
    // Pass order details from PHP to JS
    const orderData = {
        paymentMethod: "{{ $order->payment_method }}",
        hasPaidDeliveryFee: "{{ $order->has_paid_delivery_fee }}",
        orderId: "{{ $order->id }}"
    };

    document.addEventListener("DOMContentLoaded", () => {
        if (orderData.paymentMethod === "loan" && orderData.hasPaidDeliveryFee === "no") {
            const modalEl = document.getElementById("processingFeeModal");
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            // Show message when wallet is selected for loan orders
            const walletOption = document.getElementById("walletOption");
            const walletInfo = document.getElementById("walletPaymentInfo");
            
            if (walletOption) {
                walletOption.addEventListener("change", function() {
                    if (this.checked) {
                        if (walletInfo) {
                            walletInfo.style.display = 'block';
                        }
                        // Show alert message
                        alert("Aurelius Wallet funds are only available for outright purchases.\n\nFor instalment payments, please use Paystack or Fincra payment options. Thank you.");
                        // Revert selection to Paystack
                        document.getElementById("paystackOption").checked = true;
                        if (walletInfo) {
                            walletInfo.style.display = 'none';
                        }
                    }
                });
            }

            document.getElementById("proceedPaymentBtn").addEventListener("click", () => {
                const selectedGateway = document.querySelector("input[name='gateway']:checked").value;

                fetch("{{ route('pay.processing.fee.onspot') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        payment_type: selectedGateway,
                        order_id: orderData.orderId
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === "success") {
    if (data.url) {
        window.location.href = data.url;
    } else {
            showAlert(data.message, 'success');

setTimeout(() => {
            window.location.href = "{{ route('user.orders') }}";
        }, 5000);    }
} else {
    showAlert(data.message || "Something went wrong. Try again later.", 'error');
}


                })
                .catch(err => {
                    console.error(err);
                    alert("Server error. Please try again later.");
                });
            });
        }
    });


    /**
 * Robust showAlert that tries multiple fallbacks if a modal/backdrop covers it.
 * usage: showAlert('Message', 'error'|'success'|'warning', { duration: 3000 })
 */
function showAlert(message, type = 'error', opts = {}) {
  const duration = typeof opts.duration === 'number' ? opts.duration : 5000;
  const portalId = 'global-alert-portal';
  let portal = document.getElementById(portalId);

  // create portal if missing
  if (!portal) {
    portal = document.createElement('div');
    portal.id = portalId;
    Object.assign(portal.style, {
      position: 'fixed',
      top: '0',
      left: '0',
      right: '0',
      pointerEvents: 'none',      // doesn't block clicks
      zIndex: '2147483647',       // very high by default
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'flex-end',
      gap: '10px',
      padding: '20px',
      boxSizing: 'border-box'
    });

    // Try append to body; if that fails use documentElement as fallback
    try {
      document.body.appendChild(portal);
    } catch (e) {
      document.documentElement.appendChild(portal);
    }
  }

  // create alert node
  const alert = document.createElement('div');
  alert.className = `custom-alert ${type}`;
  alert.textContent = message;

  // base styles for the alert
  Object.assign(alert.style, {
    pointerEvents: 'auto',              // allow dismiss buttons in future
    background: type === 'success' ? '#2ecc71' : type === 'warning' ? '#f1c40f' : '#e74c3c',
    color: '#fff',
    padding: '10px 14px',
    borderRadius: '8px',
    boxShadow: '0 6px 18px rgba(0,0,0,0.18)',
    transform: 'translateY(-10px)',
    opacity: '0',
    transition: 'opacity 0.25s ease, transform 0.25s ease',
    maxWidth: '420px',
    wordBreak: 'break-word',
    zIndex: '2147483648' // ensure alert itself tries to be above portal
  });

  portal.appendChild(alert);

  // animate in
  requestAnimationFrame(() => {
    alert.style.opacity = '1';
    alert.style.transform = 'translateY(0)';
  });

  // After a short delay, verify visibility. If covered, apply stronger fallback.
  setTimeout(() => {
    try {
      const r = alert.getBoundingClientRect();
      // pick a point inside the alert
      const x = Math.min(Math.max(r.left + r.width / 2, 0), window.innerWidth - 1);
      const y = Math.min(Math.max(r.top + 10, 0), window.innerHeight - 1);
      const topEl = document.elementFromPoint(x, y);

      const isCovered = topEl && !alert.contains(topEl) && topEl !== alert;

      if (isCovered) {
        // Fallback: force a super-high z-index and position on the alert itself,
        // and promote to its own layer with translateZ.
        portal.style.zIndex = '999999999999999';
        alert.style.zIndex = '999999999999999';
        alert.style.position = 'fixed';
        // lock the current screen position for the alert
        alert.style.left = `${r.left}px`;
        alert.style.top = `${r.top}px`;
        alert.style.right = 'auto';
        alert.style.transform = 'translateZ(999999px) translateY(0)';
        // add a subtle border to ensure visibility
        alert.style.border = '1px solid rgba(0,0,0,0.05)';
        console.warn('showAlert: fallback applied (alert was covered).');
      }
    } catch (err) {
      // ignore failures of elementFromPoint on some environments
      console.warn('showAlert: visibility check failed', err);
    }
  }, 120);

  // Animate out and remove
  setTimeout(() => {
    alert.style.opacity = '0';
    alert.style.transform = 'translateY(-10px)';
    setTimeout(() => {
      if (alert && alert.parentNode) alert.parentNode.removeChild(alert);
      // if portal becomes empty remove it
      if (portal && portal.childElementCount === 0 && portal.parentNode) {
        portal.parentNode.removeChild(portal);
      }
    }, 260);
  }, duration);
}

</script>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const orderId = {{ $order->id }};



function setLoading(element, isLoading) {
    if (isLoading) {
        element.classList.add('loading');
        element.disabled = true;
    } else {
        element.classList.remove('loading');
        element.disabled = false;
    }
}

// Radio button interactions
document.addEventListener('DOMContentLoaded', function() {
    // Payment type radio buttons
    const paymentRadios = document.querySelectorAll('input[name="payment_type"]');
    const paymentOptions = document.querySelectorAll('.radio-option');

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            paymentOptions.forEach(option => {
                if (option.querySelector('input[name="payment_type"]')) {
                    option.classList.toggle('selected', option.querySelector('input').checked);
                }
            });
        });
    });

    // Mandatory fee radio buttons
    const feeRadios = document.querySelectorAll('input[name="mandatory_fee"]');

    feeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            paymentOptions.forEach(option => {
                if (option.querySelector('input[name="mandatory_fee"]')) {
                    option.classList.toggle('selected', option.querySelector('input').checked);
                }
            });
        });
    });
});

async function markAsDelivered() {
    const btn = document.querySelector('.btn-delivery');
    setLoading(btn, true);

    try {
        const response = await fetch(`/orders/${orderId}/delivery`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ delivered: true })
        });

        const result = await response.json();

        if (result.success) {
            showAlert('✅ Order marked as delivered!', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Failed to update delivery status', 'error');
    } finally {
        setLoading(btn, false);
    }
}

async function unmarkDelivered() {
    if (!confirm('Are you sure you want to unmark this order as delivered?')) {
        return;
    }

    const btn = document.querySelector('.btn-delivery');
    setLoading(btn, true);

    try {
        const response = await fetch(`/orders/${orderId}/delivery`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ delivered: false })
        });

        const result = await response.json();

        if (result.success) {
            showAlert('↩️ Delivery status removed!', 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Failed to update delivery status', 'error');
    } finally {
        setLoading(btn, false);
    }
}

async function updatePaymentType() {
    const selectedPaymentType = document.querySelector('input[name="payment_type"]:checked')?.value;

    if (!selectedPaymentType) {
        showAlert('Please select a payment type', 'error');
        return;
    }

    const btn = document.querySelector('.btn-payment');
    setLoading(btn, true);

    try {
        const response = await fetch("{{ route('order.processing') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                payment_type: selectedPaymentType,
                order_id: orderId
            })
        });

        const result = await response.json();

        if (result.status === "success") {
            // 🚀 redirect user to the payment page
            window.location.href = result.url;
        } else {
            showAlert(result.message || 'Something went wrong', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Failed to update payment type', 'error');
    } finally {
        setLoading(btn, false);
    }
}


async function updateMandatoryFee() {
    const selectedFee = document.querySelector('input[name="mandatory_fee"]:checked')?.value;

    if (selectedFee === undefined) {
        showAlert('Please select a mandatory fee option', 'error');
        return;
    }

    const btn = document.querySelector('.btn-fee');
    setLoading(btn, true);

    try {
        const response = await fetch(`/orders/${orderId}/mandatory-fee`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ mandatory_fee: selectedFee === '1' })
        });

        const result = await response.json();

        if (result.success) {
            showAlert(`💸 Mandatory fee updated!`, 'success');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showAlert(result.message, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('Failed to update mandatory fee', 'error');
    } finally {
        setLoading(btn, false);
    }
}
</script>

@endsection
