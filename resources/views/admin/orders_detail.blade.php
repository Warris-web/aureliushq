@extends('admin.app')

@section('content')



<!-- Add this CSS to your existing <style> section -->
<style>
    /* Print Button Styling */
    .print-btn {
        background: linear-gradient(135deg, #10b981, #059669);
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

    .print-btn:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }

    /* Print Styles */
    @media print {
        /* Hide elements that shouldn't be printed */
        .back-btn,
        .print-btn,
        .order-management,
        .action-buttons,
        .alert,
        nav,
        footer,
        .sidebar {
            display: none !important;
        }

        /* Reset page styles for printing */
        body {
            background: white;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: none;
        }

        .order-header {
            border: 2px solid #000;
            page-break-after: avoid;
        }

        .order-details {
            box-shadow: none;
            border: 1px solid #000;
        }

        .order-item {
            page-break-inside: avoid;
        }

        /* Ensure proper page breaks */
        .order-items {
            page-break-inside: auto;
        }

        /* Print-specific styling */
        .section-title {
            color: #000;
            border-bottom: 2px solid #000;
            padding-bottom: 0.5rem;
        }

        .info-item {
            border: 1px solid #ccc;
        }

        /* Make sure colors are visible in print */
        .status-display {
            border: 2px solid #000;
        }
    }
</style>
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




    /* Card-style refinement */
.order-details, .order-management {
    background: #ffffff;
    border-radius: var(--radius-xl);
    padding: 2rem;
    box-shadow: var(--shadow-md);
    border: 1px solid #f1f5f9;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.order-details:hover, .order-management:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

/* Section title styling */
.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    border-left: 4px solid var(--primary-color);
    padding-left: 0.75rem;
}

/* Info-item refinements */
.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.25rem;
    background: #f8fafc;
    border-radius: var(--radius-md);
    border: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

.info-item:hover {
    background: #f1f5f9;
    border-color: var(--primary-color);
}

/* Buttons hierarchy */
.back-btn {
    background: linear-gradient(135deg, #6366f1, #4338ca);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-lg);
    font-weight: 600;
    box-shadow: var(--shadow-md);
}

.back-btn:hover {
    background: linear-gradient(135deg, #4f46e5, #3730a3);
    transform: translateY(-2px);
}

/* Order item refinement */
.order-item {
    background: #ffffff;
    border-radius: var(--radius-lg);
    padding: 1.25rem;
    border: 1px solid #e5e7eb;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.order-item:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-3px);
}

/* Notes section enhancement */
.notes-section {
    background: #fefce8;
    border: 1px solid #fef08a;
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    font-style: italic;
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

        <div style="display: flex; gap: 0.75rem;">
        <button onclick="printOrder()" class="print-btn">
            <i class="fas fa-print"></i> Print Order
        </button>
        <a href="{{ url()->previous() }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

       
    </div>

    <div class="order-content">
        <!-- Order Details -->
        <div class="order-details">
            <h2 class="section-title"> Order Details</h2>
            
            <!-- Order Info -->
            <div class="info-grid">
                
                <div class="info-item">
    <span class="info-label">Full Name</span>
    <span class="info-value">
        {{ optional($order->user)->first_name ?? '' }} {{ optional($order->user)->last_name ?? '' }}
    </span>
</div>

<div class="info-item">
    <span class="info-label">Email</span>
    <span class="info-value">{{ optional($order->user)->email ?? 'N/A' }}</span>
</div>

<div class="info-item">
    <span class="info-label">Phone</span>
    <span class="info-value">{{ optional($order->user)->phone ?? 'N/A' }}</span>
</div>

<div class="info-item">
    <span class="info-label">Alt Phone</span>
    <span class="info-value">{{ $order->phone_number ?? 'N/A' }}</span>
</div>

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
                @if (!is_null($order->operational_state))
                    <div class="info-item">
                    <span class="info-label">Operational State</span>
                    <span class="info-value">{{ $order->operational_state }}</span>
                </div>

                @endif
                
                <div class="info-item">
                    <span class="info-label">Delivered</span>
                    <span class="info-value">
                        {{ $order->delivered_at ? $order->delivered_at->format('M d, Y - h:i A') : 'Not Delivered' }}
                    </span>
                </div>

                @if($order->utility_bill_file)
    <div class="info-item">
        <span class="info-label">Utility Bill</span>
        <span class="info-value">
            <a href="{{ asset($order->utility_bill_file) }}" target="_blank" class="btn btn-sm btn-primary">
                View File
            </a>
        </span>
    </div>
    @endif

    @if($order->bank_statement)
    <div class="info-item">
        <span class="info-label">Bank Statement</span>
        <span class="info-value">
            <a href="{{ asset($order->bank_statement) }}" target="_blank" class="btn btn-sm btn-primary">
                View File
            </a>
        </span>
    </div>
    @endif


@if($order->credit_score)
<div class="info-item">
    <span class="info-label">Credit Score Detail</span>
    <span class="info-value">
        <button class="btn btn-warning" onclick="openCreditModal()">View Information</button>
    </span>
</div>
@endif
@php
    $credit = json_decode($order->credit_score, true);
    $entity = $credit['data']['entity'] ?? [];
@endphp

<div id="creditModal" class="credit-modal">

    <div class="credit-modal-content">
        <span class="close-modal" onclick="closeCreditModal()">&times;</span>

        <h2>Credit Report Summary</h2>

        {{-- PERSONAL INFORMATION --}}
        <div class="section">
            <h3>Personal Information</h3>
            <div class="item"><strong>Name:</strong> {{ $entity['name'] ?? 'N/A' }}</div>
            <div class="item"><strong>BVN:</strong> {{ $entity['bvn'] ?? 'N/A' }}</div>
            <div class="item"><strong>DOB:</strong> {{ $entity['dateOfBirth'] ?? 'N/A' }}</div>
            <div class="item"><strong>Gender:</strong> {{ $entity['gender'] ?? 'N/A' }}</div>
            <div class="item"><strong>Phone:</strong> {{ $entity['phone'] ?? 'N/A' }}</div>
            <div class="item"><strong>Email:</strong> {{ $entity['email'] ?? 'N/A' }}</div>
            <div class="item"><strong>Address:</strong> {{ $entity['address'] ?? 'N/A' }}</div>
            <div class="item"><strong>Searched:</strong> {{ $credit['data']['searchedDate'] ?? 'N/A' }}</div>
        </div>

        {{-- BUREAU STATUS --}}
        @if(!empty($entity['score']['bureauStatus']))
            <div class="section">
                <h3>Bureau Status</h3>
                @foreach($entity['score']['bureauStatus'] as $key => $val)
                    <div class="item"><strong>{{ ucfirst($key) }}:</strong> {{ $val }}</div>
                @endforeach
            </div>
        @endif

        {{-- CREDIT ENQUIRIES --}}
        @if(!empty($entity['score']['creditEnquiries']))
            <div class="section">
                <h3>Credit Enquiries</h3>
                @foreach($entity['score']['creditEnquiries'] as $enq)
                    @foreach($enq['value'] ?? [] as $v)
                        <div class="item"><strong>Source:</strong> {{ $enq['source'] }}</div>
                        <div class="item"><strong>Loan Provider:</strong> {{ $v['loanProvider'] ?? '' }}</div>
                        <div class="item"><strong>Phone:</strong> {{ $v['contactPhone'] ?? '' }}</div>
                        <div class="item"><strong>Date:</strong> {{ $v['date'] ?? '' }}</div>
                        <div class="item"><strong>Reason:</strong> {{ $v['reason'] ?? '' }}</div>
                        <br>
                    @endforeach
                @endforeach
            </div>
        @endif

        {{-- CREDITORS --}}
        @if(!empty($entity['creditors']))
            <div class="section">
                <h3>Creditors</h3>
                @foreach($entity['creditors'] as $c)
                    @foreach($c['value'] ?? [] as $v)
                        <div class="item"><strong>Name:</strong> {{ $v['Name'] ?? '' }}</div>
                        <div class="item"><strong>Address:</strong> {{ $v['Address'] ?? '' }}</div>
                        <div class="item"><strong>Phone:</strong> {{ $v['Phone'] ?? '' }}</div>
                        <div class="item"><strong>Subscriber ID:</strong> {{ $v['Subscriber_ID'] ?? '' }}</div>
                        <br>
                    @endforeach
                @endforeach
            </div>
        @endif

        {{-- LOAN HISTORY --}}
        @if(!empty($entity['loanHistory']))
            <div class="section">
                <h3>Loan History</h3>
                @foreach($entity['loanHistory'] as $h)
                    @foreach($h['value'] ?? [] as $v)
                        <div class="item"><strong>Provider:</strong> {{ $v['loanProvider'] }}</div>
                        <div class="item"><strong>Account #:</strong> {{ $v['accountNumber'] }}</div>
                        <div class="item"><strong>Loan Amount:</strong> {{ $v['loanAmount'] }}</div>
                        <div class="item"><strong>Outstanding:</strong> {{ $v['outstandingBalance'] }}</div>
                        <div class="item"><strong>Status:</strong> {{ $v['status'] }}</div>
                        <div class="item"><strong>Performance:</strong> {{ $v['performanceStatus'] }}</div>
                        <br>
                    @endforeach
                @endforeach
            </div>
        @endif

        {{-- TOTAL SUMMARY --}}
        <div class="section">
            <h3>Summary Totals</h3>
            @php
                $field = fn($key) => $entity[$key][0]['value'] ?? '0';
            @endphp

            <div class="item"><strong>Total Borrowed:</strong> {{ $field('totalBorrowed') }}</div>
            <div class="item"><strong>Total Outstanding:</strong> {{ $field('totalOutstanding') }}</div>
            <div class="item"><strong>Total Loans:</strong> {{ $field('totalNoOfLoans') }}</div>
            <div class="item"><strong>Closed Loans:</strong> {{ $field('totalNoOfClosedLoans') }}</div>
            <div class="item"><strong>Active Loans:</strong> {{ $field('totalNoOfActiveLoans') }}</div>
            <div class="item"><strong>Performing Loans:</strong> {{ $field('totalNoOfPerformingLoans') }}</div>
            <div class="item"><strong>Institutions:</strong> {{ $field('totalNoOfInstitutions') }}</div>
            <div class="item"><strong>Overdue:</strong> {{ $field('totalOverdue') }}</div>
        </div>

    </div>
</div>

<style>
.credit-modal { display:none; position:fixed; z-index:9999; inset:0; background:rgba(0,0,0,0.6); }
.credit-modal-content { background:#fff; width:90%; max-width:820px; margin:3% auto; padding:25px; border-radius:12px; max-height:90vh; overflow-y:auto; }
.close-modal { float:right; font-size:27px; cursor:pointer; }
.section { margin-bottom:25px; padding-bottom:15px; border-bottom:1px solid #ddd; }
.section h3 { margin-bottom:10px; font-size:18px; }
.item { margin-bottom:6px; }
.item strong { display:inline-block; width:240px; }
</style>

<script>
function openCreditModal() {
    document.getElementById("creditModal").style.display = "block";
}

function closeCreditModal() {
    document.getElementById("creditModal").style.display = "none";
}
</script>

    
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

        <!-- Management Panel -->
        
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">


<script>
function printOrder() {
    // Store the original title
    const originalTitle = document.title;
    
    // Set a custom title for the print
    document.title = `Order_${{{ $order->order_number }}}_{{ $order->created_at->format('Y-m-d') }}`;
    
    // Trigger the print dialog
    window.print();
    
    // Restore the original title after printing
    setTimeout(() => {
        document.title = originalTitle;
    }, 100);
}

// Optional: Add keyboard shortcut (Ctrl+P or Cmd+P)
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        printOrder();
    }
});
</script>

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