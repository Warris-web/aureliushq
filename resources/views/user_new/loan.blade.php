@extends('user_new.app')

@section('content')

<style>
/* Overlay */
.clear_loan-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* Modal box */
.clear_loan-modal-box {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    width: 95%;
    max-width: 420px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    animation: fadeInUp 0.3s ease-in-out;
        margin-top:-350px !important;

}


/* Animation */
@keyframes fadeInUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Text */
.clear_loan-title {
    font-size: 20px;
    font-weight: 700;
    color: #222;
    margin-bottom: 10px;
}
.clear_loan-text {
    color: #555;
    margin-bottom: 15px;
}

/* Radio group */
.clear_loan-radio-group {
    margin-bottom: 20px;
}
.clear_loan-radio {
    display: block;
    margin-bottom: 8px;
    color: #333;
}

/* Actions */
.clear_loan-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.clear_loan-btn-cancel {
    background: #ccc;
    color: #000;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
}
.clear_loan-btn-cancel:hover {
    background: #aaa;
}
.clear_loan-btn-primary {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    cursor: pointer;
}
.clear_loan-btn-primary:hover {
    background: #218838;
}
</style>

<style>
    .loan-history-container {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
    }

    .loan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        border-bottom: 2px solid #f3f3f3;
        padding-bottom: 1rem;
    }

    .loan-header h2 {
        font-weight: 700;
        color: #ff7b00; /* Orange heading */
        margin: 0;
    }

    .loan-header p {
        margin: 0;
        font-size: 15px;
        color: #444;
    }

    .btn-back {
        background: #000;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        text-decoration: none;
        font-size: 14px;
        transition: 0.3s ease;
    }

    .btn-back:hover {
        background: #ff7b00;
        color: #fff;
    }

    .loan-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1.5rem;
        border-radius: 12px;
        overflow: hidden;
    }

    .loan-table thead {
        background: #000;
        color: #fff;
    }

    .loan-table th,
    .loan-table td {
        padding: 14px 18px;
        text-align: left;
        vertical-align: middle;
    }

    .loan-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .loan-table tbody tr:hover {
        background-color: #fff5ec; /* light orange hover */
        transition: 0.3s ease;
    }

    .badge {
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 13px;
        text-transform: capitalize;
    }

    .badge-success {
        background: #ff7b00 !important;
        color: #fff;
    }

    .badge-warning {
        background: #000 !important;
        color: #fff;
    }

    .no-data {
        text-align: center;
        padding: 2rem;
        color: #777;
        font-size: 15px;
    }
</style>

<style>
  #dashboard_food_display{
      background: #fff7f4; /* light orange */
      padding:20px;

}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    backdrop-filter: blur(3px);
}

.modal-box {
    background: #fff;
    width: 90%;
    max-width: 420px;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    animation: fadeIn 0.3s ease-out;
    margin-top:-300px !important;
}

.modal-title {
    font-size: 1.4rem;
    font-weight: bold;
    color: #d9534f;
    margin-bottom: 10px;
}

.modal-text {
    margin-bottom: 20px;
    color: #555;
    font-size: 1rem;
}

.modal-radio-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.modal-radio {
    font-size: 1rem;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-cancel {
    padding: 8px 14px;
    border: 1px solid #ccc;
    background: #f5f5f5;
    border-radius: 6px;
    cursor: pointer;
}

.btn-primary {
    padding: 8px 14px;
    border: none;
    background: darkorange;
    color: #fff;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
}

/* Smooth animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>


<!-- Clear Loan Modal -->
<div id="clear_loan_modal" class="clear_loan-modal-overlay">
    <div class="clear_loan-modal-box">
        <form id="clearLoanForm" action="{{ route('total.repayment') }}" method="post">
            @csrf

            <h2 class="clear_loan-title text-danger">Clear Outstanding Balance</h2>
            <hr/>

            <p class="clear_loan-text">
                You are about to clear <strong>{{ Auth::user()->loan_balance }}</strong> outstanding  balance.
            </p>

            <div class="clear_loan-radio-group">
                <label class="clear_loan-radio">
                    <input type="radio" name="gateway" value="paystack" checked>
                    Pay with Paystack
                </label>

                <label class="clear_loan-radio">
                    <input type="radio" name="gateway" value="fincra">
                    Pay with Fincra
                </label>

                <label class="clear_loan-radio">
                    <input type="radio" name="gateway" value="wallet">
                    Pay with Aurelius Wallet
                </label>
            </div>

            <hr/>

            <div class="clear_loan-actions">
                <button type="button" class="clear_loan-btn-cancel" onclick="closeModalClearLoan()">
                    Cancel
                </button>
                <button style="background:darkorange" type="button" class="clear_loan-btn-primary"
                        onclick="document.getElementById('clearLoanForm').submit();">
                    Proceed to Payment
                </button>
            </div>
        </form>
    </div>
</div>

  

<div style="margin-top:-20px;" class="container">
    <div id="dashboard_food_display" class="loan-history-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5><strong>Current Outstanding Bal:</strong> ₦{{ number_format(Auth::user()->loan_balance, 2) }}</h5>


             

    <a href="{{ route('dashboard') }}" class="btn btn-outline-dark btn-sm">
        ← Go Back
    </a>
        </div>
         @if(Auth::user()->loan_balance > 0) 
<a href="#" class="badge bg-success" onclick="openModalClearLoan(); return false;">
    Clear Outstanding
</a>
@endif

        @if($repayments->count())
            <div class="table-responsive">
                <table class="loan-table">
                    <thead>
                        <tr>
                            <th>Due Date</th>
                            <th>Repayment Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repayments as $repayment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($repayment->due_date)->format('M d, Y') }}</td>
                                <td>₦{{ number_format($repayment->repayment_amount, 2) }}</td>
                                <td>
                                    <span class="badge {{ $repayment->status == 'paid' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($repayment->status) }}
                                    </span>

                                    @if ($repayment->status == 'pending')
    <a href="#" class="badge bg-success" onclick="openModal({{ $repayment->id }}); return false;">
        Pay
    </a>

    <!-- Custom Modal -->
    <div id="customModal_{{ $repayment->id }}" class="modal-overlay">
        <div class="modal-box">
            <form id="repaymentForm_{{ $repayment->id }}" 
                action="{{ route('repayment.pay', $repayment->id) }}" 
                method="post">
                @csrf

                <h2 class="modal-title">Outstanding Payment</h2>
                <hr/>
                <p class="modal-text">
                    You are about to pay <strong>{{ $repayment->repayment_amount }}</strong> to continue.
                </p>

                <div class="modal-radio-group">
                    <label class="modal-radio">
                        <input type="radio" name="gateway" value="paystack" checked>
                        Pay with Paystack
                    </label>

                    <label class="modal-radio">
                        <input type="radio" name="gateway" value="fincra">
                        Pay with Fincra
                    </label>

                    <label class="modal-radio">
                        <input type="radio" name="gateway" value="wallet">
                        Pay with Aurelius Wallet
                    </label>
                </div>
                <hr/>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal({{ $repayment->id }})">
                        Cancel
                    </button>
                    <button type="button" class="btn-primary"
                        onclick="document.getElementById('repaymentForm_{{ $repayment->id }}').submit();">
                        Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-info-circle fa-2x mb-2 text-secondary"></i>
                <p>No repayment history found for this user.</p>
            </div>
        @endif
    </div>
</div>

<section class="payment-secured">
    
    <img src="{{ asset('logo2.png') }}" alt="Aurelius" class="aurelius-logo">
</section>

<style>

.payment-secured {
    text-align: center;
    padding: 30px 0;
}

.payment-secured h2 {
    font-size: 12px;
    font-weight: 700;
    margin: 0;
}

.payment-secured .by-text {
    font-size: 18px;
    margin: 5px 0 20px;
}

.payment-secured .payment-logos {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.payment-secured .payment-logos img {
    height: 40px; /* Adjust as needed */
}

.payment-secured .payment-logos .and {
    font-size: 24px;
    font-weight: bold;
}


.payment-secured .aurelius-logo {
    height: 200px; /* Adjust as needed */
    margin-top: 10px;
}
</style>


<script>
function openModal(id) {
    document.getElementById('customModal_' + id).style.display = 'flex';
}

function closeModal(id) {
    document.getElementById('customModal_' + id).style.display = 'none';
}
</script>

<script>
function openModalClearLoan() {
    document.getElementById('clear_loan_modal').style.display = 'flex';
}

function closeModalClearLoan() {
    document.getElementById('clear_loan_modal').style.display = 'none';
}
</script>


@endsection
