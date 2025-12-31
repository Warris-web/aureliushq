@extends('admin.app')

@section('content')
<style>
:root {
    --primary-color: #ff8c00; /* Orange */
    --primary-dark: #d97706;
    --black-color: #000000;
    --text-primary: #1f1f1f;
    --text-secondary: #6b7280;
    --bg-light: #fffaf5;
    --radius: 12px;
    --shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
}

.container {
    margin: 2rem auto;
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 2rem;
    position: relative;
}

/* Back Button */
.back-btn {
    background: var(--black-color);
    color: white;
    padding: 0.6rem 1.2rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.back-btn:hover {
    background: var(--primary-color);
    color: #fff;
}

/* Tabs */
.tabs {
    display: flex;
    gap: 1rem;
    border-bottom: 2px solid #e5e7eb;
    margin-bottom: 2rem;
}

.tab {
    padding: 0.8rem 1.4rem;
    border-radius: var(--radius) var(--radius) 0 0;
    background: var(--bg-light);
    color: var(--text-secondary);
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.tab.active {
    background: var(--primary-color);
    color: white;
}

/* Tab content */
.tab-content {
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}
.tab-content.active {
    display: block;
}

/* User header */
.user-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}
.avatar-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--black-color));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.8rem;
}
.user-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}
.detail-card {
    background: white;
    border-radius: var(--radius);
    padding: 1.5rem;
    box-shadow: var(--shadow);
}

/* Tables */
.table-container {
    overflow-x: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 0.8rem;
    border-bottom: 1px solid #e5e7eb;
    text-align: left;
}
th {
    background: var(--bg-light);
    font-weight: 600;
    color: var(--black-color);
}
tr:hover {
    background: #fff7ec;
}

/* Search + Pagination */
.search-box {
    margin-bottom: 1rem;
}
.search-box input {
    padding: 0.6rem 1rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    width: 250px;
}
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
    gap: 0.4rem;
}
.page-btn {
    padding: 0.4rem 0.8rem;
    background: var(--bg-light);
    border: 1px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
}
.page-btn.active {
    background: var(--primary-color);
    color: white;
}
@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity: 1;}
}
</style>

<div class="container">

    <a href="{{ url()->previous() }}" class="back-btn">
        <i class="mdi mdi-arrow-left"></i> Back
    </a>

    <h2 style="margin-top:1rem; color: var(--black-color);">👤 User Overview</h2>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" data-tab="details">User Details</div>
        <div class="tab" data-tab="history">User History</div>
        <div class="tab" data-tab="referrals">Referred Users</div>
    </div>

    <!-- USER DETAILS -->
    <div id="details" class="tab-content active">
        <div class="user-header">
            <div class="avatar-circle">
                {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
            </div>
            <div>
                <h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p>{{ $user->email }}</p>
                <p>{{ $user->phone }}</p>
@if(!empty($user->student_id))
    <div style="margin-bottom: 10px;">
        <p><strong>Student ID:</strong></p>

                <p>{{ $user->school_name }}</p>

        {{-- Display Image --}}
        <img 
            src="{{ asset($user->student_id) }}" 
            alt="Student ID" 
            style="width:150px; border-radius:10px; display:block; margin-bottom:5px;"
        >

        {{-- View Image Link --}}
        <a href="{{ asset($user->student_id) }}" 
           target="_blank" 
           style="color:#007bff; text-decoration:underline;">
           View Image
        </a>
    </div>
@endif

            </div>
        </div>

        <div class="user-details-grid">
            <div class="detail-card">
                <h6 style="color: var(--primary-color);">Account Info</h6>
                <p><strong>Wallet:</strong> ₦{{ number_format($user->wallet_balance, 2) }}</p>
                <p><strong>Loan:</strong> ₦{{ number_format($user->loan_balance, 2) }}</p>
                <p><strong>Employee Status:</strong> {{ $user->employee_status }}</p>
                <p><strong>User Level:</strong> {{ $user->level ?? 'Not Avalable Yet' }}</p>
<p><strong>Status:</strong>
    @if($user->has_done_kyc === 'yes')
        <span style="
            background:#d4f8d4;
            color:#0f7b0f;
            padding:4px 10px;
            border-radius:6px;
            font-weight:bold;
        ">
            KYC Completed
        </span>
    @else
        <span style="
            background:#f8d4d4;
            color:#b20909;
            padding:4px 10px;
            border-radius:6px;
            font-weight:bold;
        ">
            KYC Not Completed
        </span>
    @endif
</p>
                <p><strong>Joined:</strong> {{ $user->created_at->format('M j, Y g:i A') }}</p>
            </div>

            <div class="detail-card">
                <h6 style="color: var(--primary-color);">Location</h6>
                <p><strong>Country:</strong> {{ $user->country ?? 'N/A' }}</p>
                <p><strong>State:</strong> {{ $user->state ?? 'N/A' }}</p>
                <p><strong>LGA:</strong> {{ $user->lga ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- USER HISTORY -->
    <div id="history" class="tab-content">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search history...">
        </div>

        <div class="table-container">
            <table id="historyTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $h)
                    <tr>
                        <td>{{ $h->id }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $h->type)) }}</td>
                        <td>₦{{ number_format($h->amount, 2) }}</td>
                        <td>{{ $h->message }}</td>
                        <td>{{ $h->created_at->format('M j, Y g:i A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination" id="pagination"></div>
    </div>

    <!-- USER REFERRALS -->
    <div id="referrals" class="tab-content">
        <h4 style="margin-bottom:1rem; color: var(--primary-color);">Referred Users</h4>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($userReferrals as $index => $ref)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ref->referred->first_name }} {{ $ref->referred->last_name }}</td>
                        <td>{{ $ref->referred->email }}</td>
                        <td>{{ $ref->referred->created_at->format('M j, Y g:i A') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;">No referrals yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// --- Tabs ---
const tabs = document.querySelectorAll('.tab');
const tabContents = document.querySelectorAll('.tab-content');
tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        tabContents.forEach(c => c.classList.remove('active'));
        document.getElementById(tab.dataset.tab).classList.add('active');
    });
});

// --- Search + Pagination for history ---
const rowsPerPage = 5;
let currentPage = 1;
const rows = [...document.querySelectorAll('#historyTable tbody tr')];
const pagination = document.getElementById('pagination');

function displayTable(page) {
    rows.forEach((row, i) => {
        row.style.display = (i >= (page - 1) * rowsPerPage && i < page * rowsPerPage) ? '' : 'none';
    });
}
function setupPagination() {
    pagination.innerHTML = '';
    const pageCount = Math.ceil(rows.length / rowsPerPage);
    for (let i = 1; i <= pageCount; i++) {
        const btn = document.createElement('button');
        btn.innerText = i;
        btn.classList.add('page-btn');
        if (i === currentPage) btn.classList.add('active');
        btn.addEventListener('click', () => {
            currentPage = i;
            displayTable(i);
            setupPagination();
        });
        pagination.appendChild(btn);
    }
}
displayTable(currentPage);
setupPagination();

document.getElementById('searchInput').addEventListener('keyup', function() {
    const term = this.value.toLowerCase();
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
    });
});
</script>
@endsection
