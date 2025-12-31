@extends('user.app')

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
        font-size: 2rem;
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

    .order-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        align-items: start;
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
        display: grid;
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
            <h1 class="order-title">
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
        <a href="{{ url('/orders') }}" class="back-btn">
             Back to Orders
        </a>
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
                    <span class="info-value">{{ $order->payment_method ? ucfirst($order->payment_method) : 'Not Set' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Home Address</span>
                    <span class="info-value">{{ $order->delivery_address ? ucfirst($order->delivery_address) : 'Not Set' }}</span>
                </div>
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
            </div>

            <!-- Order Items -->
            <div class="order-items">
                <h3 class="section-title"> Ordered Items</h3>
                
                @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="item-icon"></div>
                        
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

        <!-- Management Panel -->
        <div class="order-management">
            <h2 class="section-title">Management Panel</h2>

            <!-- Delivery Status Management -->
            <div class="management-section">
                <div class="section-header">
                    <span class="section-icon"></span>
                    <span class="section-label">Delivery Status</span>
                    <span class="current-value">
                        {{ $order->delivered_at ? 'Delivered' : 'Pending' }}
                    </span>
                </div>
                
                @if(!$order->delivered_at && $order->status === 'ready')
                    <button class="update-btn btn-delivery" onclick="markAsDelivered()">
                     Mark as Delivered
                    </button>
                    @endif
                {{-- @else
                    <button class="update-btn btn-delivery" onclick="unmarkDelivered()">
                     Unmark Delivery
                    </button>
                @endif --}}
            </div>

            @if($order->has_paid_delivery_fee =='no')
            <!-- Payment Type Management -->
            <div class="management-section">
                <h4 class="mb-3">Processing Fee Payment #1000.00</h4>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="payment_type" value="fincra" class="radio-input" >
                        <div>
                            <div class="radio-label">Fincra</div>
                            {{-- <div class="radio-description">Pay from user's wallet balance</div> --}}
                        </div>
                    </label>
                    
                    <label class="radio-option ">
                        <input type="radio" name="payment_type" value="paystack" class="radio-input">
                        <div>
                            <div class="radio-label">Paystack</div>
                            {{-- <div class="radio-description">Add to user's loan account</div> --}}
                        </div>
                    </label>
                </div>
                
                <button class="update-btn btn-payment" onclick="updatePaymentType()">
                    Pay Processing Fee
                </button>
            </div>
            @endif

        </div>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const orderId = {{ $order->id }};

function showAlert(message, type = 'error') {
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    document.body.appendChild(alert);
    
    setTimeout(() => alert.classList.add('show'), 100);
    setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => document.body.removeChild(alert), 300);
    }, 3000);
}

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