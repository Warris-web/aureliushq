@extends('admin.app')

@section('content')
<style>
    .loan-container {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-top: 2rem;
    }

    .loan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .loan-header h2 {
        color: darkorange;
        font-weight: 700;
        margin: 0;
    }

    .search-box {
        position: relative;
        width: 250px;
    }

    .search-box input {
        width: 100%;
        border: 2px solid darkorange;
        border-radius: 30px;
        padding: 8px 35px 8px 15px;
        font-size: 14px;
        outline: none;
        transition: 0.3s ease;
    }

    .search-box input:focus {
        box-shadow: 0 0 0 3px rgba(255,140,0,0.2);
    }

    .search-box i {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: darkorange;
    }

    .loan-table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
    }

    .loan-table thead {
        background-color: darkorange;
        color: #fff;
        text-align: left;
    }

    .loan-table th, .loan-table td {
        padding: 14px 18px;
        vertical-align: middle;
    }

    .loan-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .loan-table tbody tr:hover {
        background-color: #fff3e0;
        transition: 0.3s ease;
    }

    .btn-view {
        background: black;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 14px;
        text-decoration: none;
        transition: 0.2s ease;
    }

    .btn-view:hover {
        background: darkorange;
        color: #fff;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .pagination .page-link {
        border: none;
        color: #0d6efd;
    }

    .pagination .active .page-link {
        background: #0d6efd;
        color: #fff;
        border-radius: 6px;
    }

    .no-data {
        text-align: center;
        padding: 2rem;
        color: #777;
    }
</style>

<div class="container">
    <div class="loan-container">
        <div class="loan-header">
            <h2>Manage User Outstanding</h2>
            <div class="search-box">
                <input type="text" id="loanSearch" placeholder="Search user..." />
                <i class="fas fa-search"></i>
            </div>
        </div>

        @if($users->count())
            <div class="table-responsive">
                <table class="loan-table" id="loanTable">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone Contact</th>
                            <th>Outstanding Balance</th>
                            <th>Due Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }} <br/> {{ $user->alt_phone }}</td>
                                <td>₦{{ number_format($user->loan_balance, 2) }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($user->next_due_date)->format('M d, Y') }}</td>

                                <td>
                                    <a href="{{ route('admin.loan_history', $user->id) }}" class="btn-view">
                                        <i class="fas fa-history me-1"></i> View History
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-info-circle fa-2x mb-2 text-secondary"></i>
                <p>No users currently owe loans.</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("loanSearch");
    const tableRows = document.querySelectorAll("#loanTable tbody tr");

    searchInput.addEventListener("keyup", function () {
        const filter = this.value.toLowerCase();
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
});
</script>
@endsection
