<?php
// Orders Index View - Enhanced with collapsible details and action buttons
// Create: resources/views/user/orders/index.blade.php
?>

@extends('user.app')

@section('content')
<style>
    .orders-header {
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .orders-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .back-btn {
        background: var(--primary-color);
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
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }

    .orders-grid {
        display: grid;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .order-card {
        background: var(--bg-primary);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .order-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .order-info h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .order-meta {
        font-size: 0.875rem;
        color: var(--text-secondary);
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .order-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-lg);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: capitalize;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-confirmed { background: #dbeafe; color: #1e40af; }
    .status-preparing { background: #e0e7ff; color: #3730a3; }
    .status-ready { background: #dcfce7; color: #166534; }
    .status-delivered { background: #dcfce7; color: #166534; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    /* Quick Actions Bar */
    .quick-actions {
        padding: 1rem 1.5rem;
        background: var(--bg-secondary);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }

    .action-group {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .quick-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .btn-address {
        background: #8b5cf6;
        color: white;
    }

    .btn-address:hover {
        background: #7c3aed;
        transform: translateY(-1px);
    }

    .btn-processing {
        background: #f59e0b;
        color: white;
    }

    .btn-processing:hover {
        background: #d97706;
        transform: translateY(-1px);
    }

    .btn-wallet {
        background: #10b981;
        color: white;
    }

    .btn-wallet:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-loan {
        background: #3b82f6;
        color: white;
    }

    .btn-loan:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-details {
        background: #1f2937;
        color: white;
        margin-left: auto;
        font-size: 0.9rem;
        padding: 0.75rem 1.25rem;
        border: 2px solid #1f2937;
    }

    .btn-details:hover {
        background: #111827;
        border-color: #111827;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(31, 41, 55, 0.3);
    }

    .btn-details.expanded {
        background: #dc2626;
        border-color: #dc2626;
    }

    .btn-details.expanded:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }

    /* Collapsible Content */
    .order-content {
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out, padding 0.3s ease-in-out;
    }

    .order-content.expanded {
        padding: 1.5rem;
        max-height: 1000px;
    }

    .order-items {
        margin-bottom: 1rem;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--bg-tertiary);
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .item-details {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .item-total {
        font-weight: 600;
        color: var(--primary-color);
    }

    .order-total {
        text-align: right;
        padding-top: 1rem;
        border-top: 2px solid var(--border-color);
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .order-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .btn-view {
        background: var(--primary-color);
        color: white;
    }

    .btn-view:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: var(--danger-color);
        color: white;
    }

    .btn-cancel:hover {
        background: var(--danger-dark);
        transform: translateY(-1px);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background-color: #ffffff;
        margin: 5% auto;
        padding: 2rem;
        border: none;
        border-radius: var(--radius-xl);
        width: 90%;
        max-width: 500px;
        position: relative;
        animation: modalSlideIn 0.3s ease-out;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        color: #1f2937;
    }

    @keyframes modalSlideIn {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s ease;
    }

    .close:hover {
        color: #1f2937;
        background-color: #f3f4f6;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #1f2937;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--radius-md);
        background: #ffffff;
        color: #1f2937;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: var(--radius-md);
        background: #ffffff;
        color: #1f2937;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    .form-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-lg);
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .payment-option:hover {
        border-color: var(--primary-color);
        background: var(--bg-secondary);
    }

    .payment-option.selected {
        border-color: var(--primary-color);
        background: rgba(var(--primary-color), 0.1);
    }

    .payment-icon {
        font-size: 1.5rem;
        width: 40px;
        text-align: center;
    }

    .payment-details h4 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }

    .payment-details p {
        margin: 0;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .repayment-options {
        display: none;
        margin-top: 1rem;
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: var(--radius-md);
    }

    .repayment-options.show {
        display: block;
    }

    .modal-footer {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .quick-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .action-group {
            justify-content: center;
        }

        .orders-title {
            font-size: 1.5rem;
        }

        .modal-content {
            width: 95%;
            margin: 10% auto;
            padding: 1.5rem;
        }
    }
</style>

<div style="margin-top:50px;" class="container">
    <div class="orders-header">
        <h1 class="orders-title">My Orders</h1>
        <a href="{{ route('user.packages') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Market
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="orders-grid">
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <h3>{{ $order->order_number }}</h3>
                            <div class="order-meta">
                                <span><i class="fas fa-calendar"></i> {{ $order->created_at->format('M j, Y \a\t g:i A') }}</span>
                                <span><i class="fas fa-utensils"></i> {{ count($order->items) }} item(s)</span>
                                <span><i class="fas fa-naira-sign"></i> ₦{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                        <span class="order-status status-{{ $order->status }}">
                            @switch($order->status)
                                @case('pending')
                                    <i class="fas fa-clock"></i> Pending
                                    @break
                                @case('confirmed')
                                    <i class="fas fa-check-circle"></i> Confirmed
                                    @break
                                @case('preparing')
                                    <i class="fas fa-fire"></i> Preparing
                                    @break
                                @case('ready')
                                    <i class="fas fa-check-double"></i> Ready
                                    @break
                                @case('delivered')
                                    <i class="fas fa-shipping-fast"></i> Delivered
                                    @break
                                @case('cancelled')
                                    <i class="fas fa-times-circle"></i> Cancelled
                                    @break
                            @endswitch
                        </span>
                        <a href="{{ route('user.orders.show', $order->order_number) }}" class="btn btn-primary">View Detail</a>

                    </div>

                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state text-center p-5">
    {{-- <div class="empty-icon mb-3" style="font-size:3rem;">🍽️</div> --}}
    <h3 class="fw-bold text-secondary mb-2">No Orders Yet</h3>
    <p class="text-muted mb-4">Your delicious journey starts here. Place your first order and it will show up below.</p>
    <a href="{{ route('user.packages') }}" 
       class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
        <i class="fas fa-shopping-cart me-2"></i> Start Shopping
    </a>
</div>

<style>
.empty-state {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    max-width: 500px;
    margin: 2rem auto;
    transition: all 0.3s ease;
}
.empty-state:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}
.empty-icon {
    font-size: 3rem;
    line-height: 1;
}

</style>
    @endif
</div>

<!-- Address Modal -->
<div id="addressModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Add Delivery Address</h2>
            <button class="close" onclick="closeModal('addressModal')">&times;</button>
        </div>
        <form id="addressForm">
            <div class="form-group">
                <label class="form-label" for="street">Street Address</label>
                <input type="text" class="form-input" id="street" name="street" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="city">City</label>
                <input type="text" class="form-input" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="state">State</label>
                <input type="text" class="form-input" id="state" name="state" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="landmark">Landmark (Optional)</label>
                <input type="text" class="form-input" id="landmark" name="landmark">
            </div>
            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="tel" class="form-input" id="phone" name="phone" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="quick-btn" onclick="closeModal('addressModal')">Cancel</button>
                <button type="submit" class="quick-btn btn-address">Save Address</button>
            </div>
        </form>
    </div>
</div>

<!-- Processing Fee Modal -->
<div id="processingModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Pay Processing Fee</h2>
            <button class="close" onclick="closeModal('processingModal')">&times;</button>
        </div>
        <div style="text-align: center; padding: 2rem 0;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">💳</div>
            <h3>Processing Fee: ₦500</h3>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">This fee covers order processing and handling</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <button class="quick-btn btn-processing" onclick="processPayment('processing')">
                    <i class="fas fa-credit-card"></i> Pay Now
                </button>
                <button class="quick-btn" onclick="closeModal('processingModal')">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Payment Options</h2>
            <button class="close" onclick="closeModal('paymentModal')">&times;</button>
        </div>
        <form id="paymentForm">
            <div class="payment-option" onclick="selectPaymentMethod('wallet')">
                <div class="payment-icon">💰</div>
                <div class="payment-details">
                    <h4>Wallet Payment</h4>
                    <p>Pay instantly from your wallet balance</p>
                </div>
                <input type="radio" name="payment_method" value="wallet" style="margin-left: auto;">
            </div>
            
            <div class="payment-option" onclick="selectPaymentMethod('loan')">
                <div class="payment-icon">🏦</div>
                <div class="payment-details">
                    <h4>Loan Payment</h4>
                    <p>Pay later with flexible repayment options</p>
                </div>
                <input type="radio" name="payment_method" value="loan" style="margin-left: auto;">
            </div>

            <div class="repayment-options" id="repaymentOptions">
                <h4 style="margin-bottom: 1rem;">Repayment Schedule</h4>
                <div class="form-group">
                    <label class="form-label">Choose your repayment plan:</label>
                    <select class="form-select" name="repayment_schedule">
                        <option value="weekly">Weekly - Lower amounts, more frequent</option>
                        <option value="monthly">Monthly - Higher amounts, less frequent</option>
                    </select>
                </div>
                <div style="background: var(--bg-tertiary); padding: 1rem; border-radius: var(--radius-md); margin-top: 1rem;">
                    <small style="color: var(--text-secondary);">
                        <strong>Weekly Plan:</strong> ₦125 per week for 4 weeks<br>
                        <strong>Monthly Plan:</strong> ₦500 per month for 1 month<br>
                        <em>Interest rates may apply based on your credit score.</em>
                    </small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="quick-btn" onclick="closeModal('paymentModal')">Cancel</button>
                <button type="submit" class="quick-btn btn-wallet">Proceed to Payment</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentOrderId = null;

// Toggle order details
function toggleOrderDetails(orderId) {
    const content = document.getElementById(orderId);
    const orderIdNumber = orderId.split('-')[1];
    const chevron = document.getElementById('chevron-' + orderIdNumber);
    const detailsBtn = document.getElementById('details-btn-' + orderIdNumber);
    const detailsText = document.getElementById('details-text-' + orderIdNumber);
    
    if (content.classList.contains('expanded')) {
        content.classList.remove('expanded');
        chevron.classList.remove('fa-chevron-up');
        chevron.classList.add('fa-chevron-down');
        detailsBtn.classList.remove('expanded');
        detailsText.textContent = 'Show Order Details';
    } else {
        content.classList.add('expanded');
        chevron.classList.remove('fa-chevron-down');
        chevron.classList.add('fa-chevron-up');
        detailsBtn.classList.add('expanded');
        detailsText.textContent = 'Hide Order Details';
    }
}

// Modal functions
function openAddressModal(orderId) {
    currentOrderId = orderId;
    document.getElementById('addressModal').style.display = 'block';
}

function openProcessingModal(orderId) {
    currentOrderId = orderId;
    document.getElementById('processingModal').style.display = 'block';
}

function openPaymentModal(orderId, method = null) {
    currentOrderId = orderId;
    document.getElementById('paymentModal').style.display = 'block';
    
    if (method) {
        selectPaymentMethod(method);
    }
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    currentOrderId = null;
}

function selectPaymentMethod(method) {
    // Clear previous selections
    document.querySelectorAll('.payment-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.checked = false;
    });
    
    // Select current method
    const selectedOption = document.querySelector(`input[value="${method}"]`).closest('.payment-option');
    selectedOption.classList.add('selected');
    document.querySelector(`input[value="${method}"]`).checked = true;
    
    // Show/hide repayment options
    const repaymentOptions = document.getElementById('repaymentOptions');
    if (method === 'loan') {
        repaymentOptions.classList.add('show');
    } else {
        repaymentOptions.classList.remove('show');
    }
}

function processPayment(type) {
    // Handle payment processing
    console.log(`Processing ${type} payment for order ${currentOrderId}`);
    alert(`${type.charAt(0).toUpperCase() + type.slice(1)} payment initiated for order ${currentOrderId}`);
    closeModal(`${type}Modal`);
}

// Form submissions
document.getElementById('addressForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    console.log('Address form submitted for order:', currentOrderId, Object.fromEntries(formData));
    alert('Address saved successfully!');
    closeModal('addressModal');
});

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    console.log('Payment form submitted for order:', currentOrderId, Object.fromEntries(formData));
    alert('Payment processed successfully!');
    closeModal('paymentModal');
});

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
            currentOrderId = null;
        }
    });
}
</script>
@endsection