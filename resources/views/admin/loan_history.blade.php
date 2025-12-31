@extends('admin.app')

@section('content')
<style>
    body {
        background-color: #f6f6f6;
    }

    .outstanding-container {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
        transition: all 0.3s ease;
    }

    .outstanding-container:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        border-bottom: 2px solid #ff7b00;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
    }

    .header-section h3 {
        color: #000;
        font-weight: 700;
        font-size: 22px;
        margin: 0;
    }

    .header-section p {
        color: #444;
        font-size: 15px;
        margin-top: 5px;
    }

    .btn-back {
        background: #000;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #ff7b00;
        color: #fff;
    }

    .card {
        border: none;
        border-left: 4px solid #ff7b00;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        transition: 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        background: #000;
        color: #fff;
        font-weight: 600;
        padding: 0.9rem 1.2rem;
    }

    .card-header a {
        color: #ff7b00;
        text-decoration: none;
        transition: 0.3s;
    }

    .card-header a:hover {
        text-decoration: underline;
    }

    .card-body {
        padding: 1rem 1.5rem;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background: #ff7b00;
        color: #fff;
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
    }

    .table-striped tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:hover {
        background-color: #fff4e6;
        transition: 0.3s ease;
    }

    .badge {
        border-radius: 50px;
        padding: 6px 12px;
        font-size: 13px;
        text-transform: capitalize;
        font-weight: 600;
    }

    .bg-success {
        background: #ff7b00 !important;
        color: #fff !important;
    }

    .bg-warning {
        background: #000 !important;
        color: #fff !important;
    }

    .no-data {
        text-align: center;
        padding: 2rem;
        font-size: 16px;
        color: #777;
    }
</style>

<div class="container">
    <div class="header-section">
        <div>
            <h3>Outstanding History for {{ $user->first_name }} {{ $user->last_name }}</h3>
            <p><strong>Current Outstanding Balance:</strong> ₦{{ number_format($user->loan_balance, 2) }}</p>
        </div>
        <a href="{{ route('manage.loan') }}" class="btn-back">
            ← Go Back
        </a>
    </div>

    @if($repayments->isEmpty())
        <div class="no-data">No Outstanding repayment records found.</div>
    @else
        @foreach($repayments as $orderId => $group)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.orders.show', $orderId) }}">View Order Information</a>
                    <span>Total Repayments: {{ $group->count() }}</span>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Repayment Amount</th>
                                <th>Status</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group as $repayment)
                                <tr>
                                    <td>₦{{ number_format($repayment->repayment_amount, 2) }}</td>
                                    <td>
                                        @if($repayment->status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($repayment->due_date)->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
