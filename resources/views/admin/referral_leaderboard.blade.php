@extends('admin.app')

@section('content')
<style>
    .leaderboard-container {
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

    .search-bar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1rem;
    }

    .search-bar input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 250px;
        transition: all 0.3s;
    }

    .search-bar input:focus {
        border-color: #4f46e5;
        outline: none;
    }

    table {
        width: 100%;
        border-collapse: collapse;
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

    .rank {
        font-weight: bold;
        color: #4f46e5;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 1rem;
    }

    .pagination button {
        border: 1px solid #ddd;
        background: white;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
    }

    .pagination button.active {
        background: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }

    .empty {
        text-align: center;
        padding: 20px;
        color: #777;
        font-style: italic;
    }
</style>

<div class="leaderboard-container">
    <h2><i class="mdi mdi-trophy-outline" style="color:gold;margin-right:8px;"></i> Referral Leaderboard</h2>

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search user by name or email...">
    </div>

    <table id="leaderboardTable">
        <thead>
            <tr>
                <th>Rank</th>
                <th>User</th>
                <th>Email</th>
                <th>Total Referrals</th>
                <th>Total Reward (₦)</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach($leaderboard as $index => $row)
            <tr>
                <td class="rank">#{{ $index + 1 }}</td>
                <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->total_referrals }}</td>
                <td><strong>₦{{ number_format($row->total_reward ?? 0, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="pagination" class="pagination"></div>
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
            tableBody.innerHTML = `<tr><td colspan="5" class="empty">No users found</td></tr>`;
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
        filteredRows = rows.filter(row => row.innerText.toLowerCase().includes(query));
        currentPage = 1;
        renderTable();
    });

    renderTable();
</script>
@endsection
