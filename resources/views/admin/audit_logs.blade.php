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

    .no-data {
        text-align: center;
        padding: 2rem;
        color: #777;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .pagination button {
        border: 1px solid darkorange;
        background: white;
        color: darkorange;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .pagination button:hover {
        background: darkorange;
        color: #fff;
    }

    .pagination button.active {
        background: darkorange;
        color: #fff;
    }
</style>

<div class="container">
    <div class="loan-container">
        <div class="loan-header">
            <h2>Audit Logs</h2>
            <div class="search-box">
                <input type="text" id="auditSearch" placeholder="Search logs..." />
                <i class="fas fa-search"></i>
            </div>
        </div>

        @if($logs->count())
            <div class="table-responsive">
                <table class="loan-table" id="auditTable">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>IP Address</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->first_name }} {{ $log->last_name }}</td>
                                <td>{{ $log->email }}</td>
                                <td>{{ ucfirst($log->user_role) }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->details }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination" id="pagination"></div>
        @else
            <div class="no-data">
                <i class="fas fa-info-circle fa-2x mb-2 text-secondary"></i>
                <p>No audit logs found.</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("auditSearch");
    const table = document.getElementById("auditTable");
    const rows = table.querySelectorAll("tbody tr");
    const pagination = document.getElementById("pagination");

    let rowsPerPage = 100;
    let currentPage = 1;

    function displayTable() {
        let filteredRows = Array.from(rows).filter(row => 
            row.textContent.toLowerCase().includes(searchInput.value.toLowerCase())
        );

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach(row => row.style.display = "none");
        filteredRows.slice(start, end).forEach(row => row.style.display = "");

        displayPagination(filteredRows.length);
    }

    function displayPagination(totalRows) {
        pagination.innerHTML = "";
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.classList.toggle("active", i === currentPage);
            btn.addEventListener("click", function () {
                currentPage = i;
                displayTable();
            });
            pagination.appendChild(btn);
        }
    }

    searchInput.addEventListener("keyup", function () {
        currentPage = 1;
        displayTable();
    });

    displayTable();
});
</script>
@endsection
