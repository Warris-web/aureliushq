@extends('admin.app')

@section('content')
<div class="user-management-container">
    <!-- Table Container -->
    <div class="table-container">
        <!-- Advanced Filters Card -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Users</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('manage.user') }}" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Name, Email, Phone, ID..." value="{{ request('search') }}">
                        </div>

                        <!-- KYC Status -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">KYC Status</label>
                            <select name="kyc_status" class="form-select">
                                <option value="">All KYC Status</option>
                                <option value="completed" {{ request('kyc_status') === 'completed' ? 'selected' : '' }}>KYC Completed</option>
                                <option value="pending" {{ request('kyc_status') === 'pending' ? 'selected' : '' }}>KYC Pending</option>
                            </select>
                        </div>

                        <!-- Email Verification -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Email Status</label>
                            <select name="email_verified" class="form-select">
                                <option value="">All Email Status</option>
                                <option value="verified" {{ request('email_verified') === 'verified' ? 'selected' : '' }}>Email Verified</option>
                                <option value="unverified" {{ request('email_verified') === 'unverified' ? 'selected' : '' }}>Email Unverified</option>
                            </select>
                        </div>

                        <!-- Onboarding Status -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Onboarding Status</label>
                            <select name="onboarding_status" class="form-select">
                                <option value="">All Onboarding</option>
                                <option value="completed" {{ request('onboarding_status') === 'completed' ? 'selected' : '' }}>Onboarding Complete</option>
                                <option value="pending" {{ request('onboarding_status') === 'pending' ? 'selected' : '' }}>Onboarding Pending</option>
                            </select>
                        </div>

                        <!-- Level -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">User Level</label>
                            <select name="level" class="form-select">
                                <option value="">All Levels</option>
                                <option value="low" {{ request('level') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="mid" {{ request('level') === 'mid' ? 'selected' : '' }}>Mid</option>
                                <option value="high" {{ request('level') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="market_woman" {{ request('level') === 'market_woman' ? 'selected' : '' }}>Market Woman</option>
                            </select>
                        </div>

                        <!-- Employment Status -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Employment Status</label>
                            <select name="employment_status" class="form-select">
                                <option value="">All Employment</option>
                                <option value="Student" {{ request('employment_status') === 'Student' ? 'selected' : '' }}>Student</option>
                                <option value="Employed" {{ request('employment_status') === 'Employed' ? 'selected' : '' }}>Employed</option>
                                <option value="Self-Employed" {{ request('employment_status') === 'Self-Employed' ? 'selected' : '' }}>Self-Employed</option>
                                <option value="Unemployed" {{ request('employment_status') === 'Unemployed' ? 'selected' : '' }}>Unemployed</option>
                            </select>
                        </div>

                        <!-- Account Status -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Account Status</label>
                            <select name="account_status" class="form-select">
                                <option value="">All Account Status</option>
                                <option value="active" {{ request('account_status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ request('account_status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="deactivated" {{ request('account_status') === 'deactivated' ? 'selected' : '' }}>Deactivated</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-search"></i> Apply Filters
                            </button>
                            <a href="{{ route('manage.user') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-3 small">
                                <div><strong>KYC:</strong>
                                    <span class="badge bg-success">{{ $kycSummary['completed'] ?? 0 }} Completed</span>
                                    <span class="badge bg-warning">{{ $kycSummary['pending'] ?? 0 }} Pending</span>
                                </div>
                                <div><strong>Email:</strong>
                                    <span class="badge bg-success">{{ $emailSummary['verified'] ?? 0 }} Verified</span>
                                    <span class="badge bg-warning">{{ $emailSummary['unverified'] ?? 0 }} Unverified</span>
                                </div>
                                <div><strong>Onboarding:</strong>
                                    <span class="badge bg-success">{{ $onboardingSummary['completed'] ?? 0 }} Complete</span>
                                    <span class="badge bg-warning">{{ $onboardingSummary['pending'] ?? 0 }} Pending</span>
                                </div>
                                <div><strong>Total Users:</strong> <span class="badge bg-primary">{{ $users->total() }}</span></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Level Filter Toolbar (Keep existing for DataTable compatibility) -->
        <div class="mb-2 d-flex flex-wrap gap-2 align-items-center" style="display:none !important;">
            <strong class="me-2">Filter by Level:</strong>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-level-filter="">All</button>
            <button type="button" class="btn btn-sm btn-outline-info" data-level-filter="low">Low</button>
            <button type="button" class="btn btn-sm btn-outline-warning" data-level-filter="mid">Mid</button>
            <button type="button" class="btn btn-sm btn-outline-success" data-level-filter="high">High</button>
            <button type="button" class="btn btn-sm btn-outline-danger" data-level-filter="market_woman">Market Woman</button>
        </div>
        <div class="table-wrapper">
            <table id="my-table" class="modern-table display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Level</th>
                        <th>Location</th>
                        <th>Email  Status</th>
                        <th>Account Status</th>
                        <th>Kyc Status</th>
                        <th>Onboarding Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <span class="user-id">#{{ $user->id }}</span>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <span>{{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}</span>
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info">
                                <div class="phone">{{ $user->phone ?? 'No phone' }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="role-badge role-{{ strtolower($user->user_role ?? 'user') }}">
                                {{ ucfirst($user->user_role ?? 'user') }}
                            </span>
                        </td>
                        <td>
                            @php
                                $levelColors = [
                                    'low' => 'bg-info',
                                    'mid' => 'bg-warning',
                                    'high' => 'bg-success',
                                    'market_woman' => 'bg-danger',
                                ];
                                $levelLabel = ['market_woman' => 'Market Woman'];
                                $level = $user->level ?? 'unknown';
                            @endphp
                            <span class="badge {{ $levelColors[$level] ?? 'bg-secondary' }}" style="color:white;">
                                {{ $levelLabel[$level] ?? ucfirst($level) }}
                            </span>
                        </td>
                        <td>
                            <div class="location-info">
                                <div class="country">{{ $user->country ?? 'N/A' }}</div>
                                @if($user->state)
                                <div class="state">{{ $user->state }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($user->has_verified_email ==='yes')
                                <span class="status-badge verified">
                                    <i class="fas fa-check-circle"></i>
                                    Verified
                                </span>
                            @else
                                <span class="status-badge unverified">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Unverified
                                </span>
                            @endif
                        </td>




                        <td>
    @if ($user->account_status === 'active')
        <span style="color:white;" class="badge bg-success">Active</span>
    @else
        <span style="color:white;" class="badge bg-danger">Suspended</span>
    @endif
</td>

                        <td>
                            @if($user->has_done_kyc ==='yes')
                                <span class="status-badge verified">
                                    <i class="fas fa-check-circle"></i>
                                    done
                                </span>
                            @else
                                <span class="status-badge unverified">
                                    <i class="fas fa-exclamation-circle"></i>
                                    pending
                                </span>
                            @endif
                        </td>


<td>
                            @if($user->has_paid_onboarding ==='yes')
                                <span class="status-badge verified">
                                    <i class="fas fa-check-circle"></i>
                                    paid
                                </span>
                            @else
                                <span class="status-badge unverified">
                                    <i class="fas fa-exclamation-circle"></i>
                                    pending
                                </span>
                            @endif
                        </td>


                        <td>
                            <div class="action-buttons">
                                <!-- View -->
                                <a href="{{ route('admin.users.view', $user->id) }}" class="btn-action btn-view"
                                       >
                                    <i class="fas fa-eye"></i>
                                </a>


                                <!-- View Repayment -->
                                <a href="{{ route('admin.users.repayments', $user->id) }}"
                                   class="btn-action btn-repayment" title="View Repayments">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </a>

<!-- Button to open modal -->
<a href="#"
   class="btn-action btn-repayment"
   data-bs-toggle="modal"
   data-bs-target="#editAltModal_{{ $user->id }}"
   title="Edit Alternate Contact">
    <i class="fas fa-edit"></i>
</a>


<!-- Button to open modal -->
<a href="#"
   class="btn-action btn-repayment"
   data-bs-toggle="modal"
   data-bs-target="#fundAccount_{{ $user->id }}"
   title="Admin Fund Accoubt">
    <i class="fas fa-credit-card"></i>
</a>


<div class="modal fade" id="fundAccount_{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('manage.wallet', $user->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <!-- Header -->
                <div class="modal-header" style="background-color:#000; color:#fff;">
                    <h5 class="modal-title fw-bold">
                    Manage User Wallet
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body" style="background-color:#fff;">

                    <!-- Current Wallet Balance -->
                    <div class="text-center mb-4">
                        <h6 class="fw-semibold text-muted mb-1">Current Wallet Balance</h6>
                        <h3 class="fw-bold" style="color:#ff7b00;">₦{{ number_format($user->wallet_balance, 2) }}</h3>
                    </div>

                    <!-- Amount Field -->
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Amount (₦)</label>
                        <input type="number" name="amount" min="0" step="0.01" class="form-control" placeholder="Enter amount" required>
                    </div>

                    <!-- Fancy Slider (Add or Remove) -->
                    <div class="form-group mb-4 text-center">
                        <label class="fw-semibold d-block mb-2">Select Action</label>
                        <div class="d-flex justify-content-center align-items-center">
                            <span class="me-2 fw-semibold text-danger">Remove Fund</span>
                            <label class="switch">
                                <input type="checkbox" name="action" id="actionSlider_{{ $user->id }}" checked>
                                <span class="slider round"></span>
                            </label>
                            <span class="ms-2 fw-semibold text-success">Add Fund</span>
                        </div>
                    </div>

                    <!-- Reason (optional) -->
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Reason (Optional)</label>
                        <textarea name="reason" rows="3" class="form-control" placeholder="State reason for transaction (optional)"></textarea>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white fw-semibold">
                        <i class="fas fa-check-circle me-1"></i> Proceed
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom Slider Styles -->
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #d9534f; /* red by default */
        transition: .4s;
        border-radius: 30px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #28a745; /* green when add */
    }
    input:checked + .slider:before {
        transform: translateX(30px);
    }

    /* Optional hover glow */
    .slider:hover {
        box-shadow: 0 0 6px rgba(255, 123, 0, 0.6);
    }

    .form-control:focus, textarea:focus {
        border-color: #ff7b00;
        box-shadow: 0 0 5px rgba(255, 123, 0, 0.4);
    }
</style>

<!-- Edit Modal -->
<div class="modal fade" id="editAltModal_{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.updateAltContact', $user->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Edit Alternate Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="alt_email_{{ $user->id }}">Alternate Email</label>
                        <input type="email"
                               class="form-control"
                               id="alt_email_{{ $user->id }}"
                               name="alt_email"
                               value="{{ old('alt_email', $user->alt_email) }}"
                               placeholder="Enter alternate email">
                    </div>

<div class="form-group mb-3">
                        <label for="alt_phone_{{ $user->id }}">Main Phone</label>
                        <input type="text"
                               class="form-control"
                               id="alt_phone_{{ $user->id }}"
                               name="phone"
                               value="{{ old('alt_phone', $user->phone) }}"
                               placeholder="Enter main contact phone">
                    </div>

                    <div class="form-group mb-3">
                        <label for="alt_phone_{{ $user->id }}">Alternate Phone</label>
                        <input type="text"
                               class="form-control"
                               id="alt_phone_{{ $user->id }}"
                               name="alt_phone"
                               value="{{ old('alt_phone', $user->alt_phone) }}"
                               placeholder="Enter alternate phone">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
                                @if ($user->user_role != 'admin')


                                <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn-action btn-delete"
            onclick="return confirm('Are you sure you want to change this user status?')"
            title="Toggle Account Status">
        @if ($user->account_status === 'active')
            <i class="fas fa-user-slash" style="color:red;" title="Deactivate"></i>
        @else
            <i class="fas fa-user-check" style="color:green;" title="Activate"></i>
        @endif
    </button>
</form>
                                @endif



                                @if ($user->user_role != 'admin')
                                    <!-- Delete -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-action btn-delete"
                                            onclick="return confirm('Are you sure you want to delete this user?')"
                                            title="Delete User">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endif


                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<style>
/* Main Container */
.user-management-container {
    padding: 2rem;
    background: #f8fafc;
    min-height: 100vh;
}

/* Table Container */
.table-container {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    padding:10px;
}

.table-wrapper {
    overflow-x: auto;
}

/* Modern Table Styles */
.modern-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.modern-table thead {
    background: #f8fafc;
}

.modern-table th {
    padding: 1.5rem 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
    border-bottom: 2px solid #e5e7eb;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.modern-table td {
    padding: 1.25rem 1rem;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.modern-table tr:hover {
    background: #f9fafb;
    transition: background-color 0.2s ease;
}

/* User Info Styles */
.user-info {
    display: flex;
    align-items: center;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    margin-right: 0.75rem;
}

.user-name {
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.25rem;
}

.user-email {
    font-size: 0.85rem;
    color: #6b7280;
}

.user-id {
    font-family: 'Courier New', monospace;
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.85rem;
    color: #374151;
}

/* Badge Styles */
.role-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.role-admin {
    background: #fee2e2;
    color: #dc2626;
}

.role-user {
    background: #dbeafe;
    color: #2563eb;
}

.role-moderator {
    background: #fef3c7;
    color: #d97706;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge i {
    margin-right: 0.25rem;
    font-size: 0.7rem;
}

.verified {
    background: #d1fae5;
    color: #065f46;
}

.unverified {
    background: #fef2f2;
    color: #991b1b;
}

/* Location Info */
.location-info .country {
    font-weight: 500;
    color: #111827;
}

.location-info .state {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.1rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.btn-view {
    background: #eff6ff;
    color: #2563eb;
}
.btn-view:hover {
    background: #dbeafe;
    transform: translateY(-1px);
}

.btn-edit {
    background: #f0fdf4;
    color: #16a34a;
}
.btn-edit:hover {
    background: #dcfce7;
    transform: translateY(-1px);
}

.btn-repayment {
    background: #fff7ed;
    color: #ea580c;
}
.btn-repayment:hover {
    background: #ffedd5;
    transform: translateY(-1px);
}

.btn-delete {
    background: #fef2f2;
    color: #dc2626;
}
.btn-delete:hover {
    background: #fee2e2;
    transform: translateY(-1px);
}
</style>



<script>
// ====== CONFIG ======
const rowsPerPage = 20; // number of rows per page

document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("my-table");
    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    // --- Create search box ---
    const searchBox = document.createElement("input");
    searchBox.type = "text";
    searchBox.placeholder = "Search...";
    searchBox.classList.add("form-control");
    searchBox.style.margin = "1rem 0";
    table.parentNode.insertBefore(searchBox, table);

    // --- Create pagination container ---
    const pagination = document.createElement("div");
    pagination.classList.add("pagination-container");
    pagination.style.marginTop = "1rem";
    pagination.style.display = "flex";
    pagination.style.gap = "0.5rem";
    pagination.style.flexWrap = "wrap";
    table.parentNode.appendChild(pagination);

    let currentPage = 1;

    function renderTable() {
        const query = searchBox.value.toLowerCase();
        const filteredRows = rows.filter(row =>
            row.innerText.toLowerCase().includes(query)
        );

        // Pagination logic
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = filteredRows.slice(start, end);

        // Clear and re-append
        tbody.innerHTML = "";
        visibleRows.forEach(r => tbody.appendChild(r));

        // Render pagination buttons
        pagination.innerHTML = "";
        if (totalPages > 1) {
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.textContent = i;
                btn.classList.add("page-btn");
                btn.style.padding = "0.4rem 0.8rem";
                btn.style.border = "1px solid #ddd";
                btn.style.borderRadius = "6px";
                btn.style.background = (i === currentPage) ? "#2563eb" : "#f3f4f6";
                btn.style.color = (i === currentPage) ? "white" : "#111827";
                btn.style.cursor = "pointer";

                btn.addEventListener("click", function () {
                    currentPage = i;
                    renderTable();
                });

                pagination.appendChild(btn);
            }
        }
    }

    // Initial render
    renderTable();

    // Re-render on search
    searchBox.addEventListener("input", function () {
        currentPage = 1; // reset to first page on search
        renderTable();
    });
});
</script>

@endsection
