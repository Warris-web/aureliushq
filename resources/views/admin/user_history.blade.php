@extends('admin.app')

@section('content')
<style>
    .container-history {
        background: #fff;
        border-radius: 12px;
        padding: 2rem;
        margin: 2rem auto;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }

    h2 {
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
    }

    .search-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .search-box input {
        border: 1px solid #ddd;
        padding: 10px 15px;
        border-radius: 8px;
        width: 250px;
        transition: all 0.3s;
    }

    .search-box input:focus {
        border-color: #4f46e5;
        outline: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        text-align: left;
        font-size: 14px;
    }

    th {
        background: #f9fafb;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: #374151;
    }

    tr:hover {
        background: #f9f9f9;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 1.5rem;
    }

    .pagination button {
        border: 1px solid #ddd;
        background: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pagination button.active {
        background: #4f46e5;
        color: #fff;
        border-color: #4f46e5;
    }

    .pagination button:hover {
        background: #eef2ff;
    }

    .empty {
        text-align: center;
        padding: 30px;
        color: #777;
        font-style: italic;
    }
</style>

<div class="container-history">
    <h2><i class="mdi mdi-history" style="margin-right:6px;color:#4f46e5;"></i> Earning History</h2>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search by name, email, or message...">
    </div>

    <table id="historyTable">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Type</th>
                <th>Amount (₦)</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($histories as $index => $h)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $h->first_name }} {{ $h->last_name }}</td>
                <td>{{ $h->email }}</td>
                <td>{{ ucfirst($h->type) }}</td>
                <td><strong>₦{{ number_format($h->amount, 2) }}</strong></td>
                <td>{{ $h->message }}</td>
                <td>{{ \Carbon\Carbon::parse($h->created_at)->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination" id="pagination"></div>
</div>

<script>
    const rowsPerPage = 10;
    const tableBody = document.getElementById("tableBody");
    const pagination = document.getElementById("pagination");
    const searchInput = document.getElementById("searchInput");
    let rows = Array.from(tableBody.querySelectorAll("tr"));
    let filteredRows = [...rows];
    let currentPage = 1;

    function renderTable() {
        tableBody.innerHTML = "";
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = filteredRows.slice(start, end);

        if (visibleRows.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="7" class="empty">No records found</td></tr>`;
        } else {
            visibleRows.forEach(row => tableBody.appendChild(row));
        }

        renderPagination();
    }

    function renderPagination() {
        pagination.innerHTML = "";
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (totalPages <= 1) return;

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            if (i === currentPage) btn.classList.add("active");
            btn.addEventListener("click", () => {
                currentPage = i;
                renderTable();
            });
            pagination.appendChild(btn);
        }
    }

    searchInput.addEventListener("keyup", function () {
        const query = this.value.toLowerCase();
        filteredRows = rows.filter(row =>
            row.innerText.toLowerCase().includes(query)
        );
        currentPage = 1;
        renderTable();
    });

    renderTable();
</script>
@endsection
