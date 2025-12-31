@extends('admin.app')

@section('content')
<div class="payment-records-wrapper">
    <div class="container">

        <!-- Header -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
            <div>
                <h2 style="font-size:1.875rem; font-weight:700; color:#111827; margin-bottom:0.25rem;">Wallet Purchase History</h2>
                <p style="color:#6b7280; font-size:0.875rem;">Manage and track all payment transactions</p>
            </div>

            <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;">
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#9ca3af;"></i>
                    <input id="payment-searchBox" type="text" placeholder="Search reference or package..." 
                        style="padding:0.625rem 1rem 0.625rem 2.5rem; border:1px solid #e5e7eb; border-radius:10px; width:260px; font-size:0.875rem; transition:all 0.2s;">
                </div>
                
                <button id="payment-openFilterModal" style="
                    background:#ff8c00;
                    color:white;
                    padding:0.625rem 1.25rem;
                    border:none;
                    border-radius:10px;
                    cursor:pointer;
                    display:flex;
                    align-items:center;
                    gap:0.5rem;
                    font-weight:500;
                    font-size:0.875rem;
                    transition:all 0.2s;
                    box-shadow:0 2px 4px rgba(255,140,0,0.3);
                " onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(255,140,0,0.4)';" 
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(255,140,0,0.3)';">
                    <i class="fas fa-filter"></i> <span id="payment-filterBtnText">Filter & Export</span>
                </button>
            </div>
        </div>

        <!-- Active Filters Display -->
        <div id="payment-activeFilters" style="margin-bottom:1rem; display:none;">
            <div style="display:flex; flex-wrap:wrap; gap:0.5rem; align-items:center;">
                <span style="font-size:0.875rem; color:#6b7280; font-weight:500;">Active Filters:</span>
                <div id="payment-filterTags" style="display:flex; flex-wrap:wrap; gap:0.5rem;"></div>
                <button id="payment-clearFilters" style="
                    background:transparent;
                    color:#ef4444;
                    border:none;
                    cursor:pointer;
                    font-size:0.875rem;
                    font-weight:500;
                    padding:0.25rem 0.5rem;
                    text-decoration:underline;
                ">Clear all</button>
            </div>
        </div>

        <!-- Stats - Compact -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px,1fr)); gap:0.75rem; margin-bottom:1.5rem;">
            <div style="background:linear-gradient(135deg, #ff8c00, #ff6600); border-radius:12px; padding:1rem; box-shadow:0 2px 4px rgba(255,140,0,0.2);">
                <h3 style="font-size:0.75rem; color:rgba(255,255,255,0.9); margin-bottom:0.25rem; text-transform:uppercase; letter-spacing:0.05em;">Total Amount</h3>
                <p id="payment-displayTotalAmount" style="font-size:1.25rem; font-weight:700; color:white;">₦{{ number_format($totalAmount, 2) }}</p>
            </div>
            <div style="background:#1a1a1a; border-radius:12px; padding:1rem; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="font-size:0.75rem; color:rgba(255,255,255,0.7); margin-bottom:0.25rem; text-transform:uppercase; letter-spacing:0.05em;">Total Payments</h3>
                <p id="payment-displayTotalPayments" style="font-size:1.25rem; font-weight:700; color:white;">{{ $totalPayments }}</p>
            </div>
            <div style="background:#1a1a1a; border-radius:12px; padding:1rem; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="font-size:0.75rem; color:rgba(255,255,255,0.7); margin-bottom:0.25rem; text-transform:uppercase; letter-spacing:0.05em;">Successful</h3>
                <p id="payment-displaySuccessfulPayments" style="font-size:1.25rem; font-weight:700; color:#10b981;">{{ $successfulPayments }}</p>
            </div>
        </div>

        <!-- Table -->
        <div style="background:white; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
            <div style="overflow-x:auto;">
                <table id="payment-paymentTable" style="width:100%; border-collapse:collapse;">
                    <thead style="background:#1a1a1a; border-bottom:2px solid #ff8c00;">
                        <tr>
                            <th style="padding:0.875rem 1rem; text-align:left; font-weight:600; font-size:0.875rem; color:white;">Reference</th>
                            <th style="padding:0.875rem 1rem; text-align:left; font-weight:600; font-size:0.875rem; color:white;">Package</th>
                            <th style="padding:0.875rem 1rem; text-align:left; font-weight:600; font-size:0.875rem; color:white;">Gateway</th>
                            <th style="padding:0.875rem 1rem; text-align:left; font-weight:600; font-size:0.875rem; color:white;">Amount</th>
                            <th style="padding:0.875rem 1rem; text-align:left; font-weight:600; font-size:0.875rem; color:white;">Status</th>
                            <th style="padding:0.875rem 1rem; text-align:left; font-weight:600; font-size:0.875rem; color:white;">Date</th>
                        </tr>
                    </thead>
                    <tbody id="payment-paymentTableBody">
                        @foreach($payments as $payment)
                        <tr class="payment-table-row" style="border-top:1px solid #f3f4f6; transition:background 0.15s;" 
                            onmouseover="this.style.background='#fffbf5';" 
                            onmouseout="this.style.background='white';">
                            <td style="padding:0.875rem 1rem; font-size:0.875rem; color:#111827; font-family:monospace;">{{ $payment->reference }}</td>
                            <td style="padding:0.875rem 1rem; font-size:0.875rem; color:#374151; font-weight:500;">{{ $payment->package }}</td>
                            <td style="padding:0.875rem 1rem; font-size:0.875rem; color:#6b7280;">
                                <span style="background:#f3f4f6; padding:0.25rem 0.75rem; border-radius:6px; font-weight:500;">
                                    {{ ucfirst($payment->gateway) }}
                                </span>
                            </td>
                            <td style="padding:0.875rem 1rem; font-size:0.875rem; color:#111827; font-weight:600;">₦{{ number_format($payment->amount, 2) }}</td>
                            <td style="padding:0.875rem 1rem;">
                                @if($payment->status === 'success')
                                    <span style="background:#d1fae5; color:#065f46; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:600; text-transform:uppercase;">Success</span>
                                @elseif($payment->status === 'failed')
                                    <span style="background:#fee2e2; color:#991b1b; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:600; text-transform:uppercase;">Failed</span>
                                @else
                                    <span style="background:#fef3c7; color:#92400e; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:600; text-transform:uppercase;">Pending</span>
                                @endif
                            </td>
                            <td style="padding:0.875rem 1rem; font-size:0.875rem; color:#6b7280;">{{ $payment->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="payment-noResults" style="display:none; padding:3rem; text-align:center;">
                <i class="fas fa-search" style="font-size:3rem; color:#d1d5db; margin-bottom:1rem;"></i>
                <p style="color:#6b7280; font-size:1rem;">No payments found matching your criteria</p>
            </div>

            <!-- Pagination -->
            <div id="payment-paginationContainer" style="display:flex; justify-content:space-between; align-items:center; padding:1rem; border-top:1px solid #e5e7eb; flex-wrap:wrap; gap:1rem;">
                <div style="color:#6b7280; font-size:0.875rem;">
                    Showing <span id="payment-showingStart">1</span> to <span id="payment-showingEnd">10</span> of <span id="payment-totalRecords">0</span> records
                </div>
                <div style="display:flex; gap:0.5rem; align-items:center;">
                    <button id="payment-prevPage" style="padding:0.5rem 0.75rem; border:1px solid #e5e7eb; background:white; border-radius:8px; cursor:pointer; font-size:0.875rem; color:#374151; transition:all 0.2s;" 
                        onmouseover="if(!this.disabled) {this.style.background='#f9fafb';}" 
                        onmouseout="this.style.background='white';">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div id="payment-pageNumbers" style="display:flex; gap:0.25rem;"></div>
                    <button id="payment-nextPage" style="padding:0.5rem 0.75rem; border:1px solid #e5e7eb; background:white; border-radius:8px; cursor:pointer; font-size:0.875rem; color:#374151; transition:all 0.2s;" 
                        onmouseover="if(!this.disabled) {this.style.background='#f9fafb';}" 
                        onmouseout="this.style.background='white';">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <select id="payment-recordsPerPage" style="padding:0.5rem; border:1px solid #e5e7eb; border-radius:8px; font-size:0.875rem; color:#374151;">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div id="payment-filterModal" style="
    position:fixed; inset:0; background:rgba(0,0,0,0.6);
    display:none; justify-content:center; align-items:center; z-index:1000;
    backdrop-filter:blur(4px);
">
    <div style="background:white; padding:2rem; border-radius:16px; width:90%; max-width:700px; position:relative; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); max-height:90vh; overflow-y:auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h3 style="font-size:1.5rem; font-weight:700; color:#111827;">Filter & Export Payments</h3>
            <button id="payment-closeFilterModalX" style="background:transparent; border:none; cursor:pointer; color:#9ca3af; font-size:1.5rem; padding:0; width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:8px;" 
                onmouseover="this.style.background='#f3f4f6';" 
                onmouseout="this.style.background='transparent';">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="payment-filterForm">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.25rem;">
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.5rem;">Status</label>
                    <select name="status" id="payment-status" style="width:100%; padding:0.625rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.875rem; color:#374151;">
                        <option value="">All Statuses</option>
                        <option value="success">Success</option>
                        <option value="failed">Failed</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.5rem;">Gateway</label>
                    <select name="gateway" id="payment-gateway" style="width:100%; padding:0.625rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.875rem; color:#374151;">
                        <option value="">All Gateways</option>
                        <option value="flutterwave">Flutterwave</option>
                        <option value="paystack">Paystack</option>
                        <option value="stripe">Stripe</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.5rem;">Date From</label>
                    <input type="date" id="payment-dateFrom" style="width:100%; padding:0.625rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.875rem;">
                </div>
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.5rem;">Date To</label>
                    <input type="date" id="payment-dateTo" style="width:100%; padding:0.625rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.875rem;">
                </div>
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.5rem;">Min Amount (₦)</label>
                    <input type="number" id="payment-amountMin" placeholder="0" style="width:100%; padding:0.625rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.875rem;">
                </div>
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.5rem;">Max Amount (₦)</label>
                    <input type="number" id="payment-amountMax" placeholder="0" style="width:100%; padding:0.625rem; border:1px solid #d1d5db; border-radius:8px; font-size:0.875rem;">
                </div>
            </div>

            <div style="display:flex; justify-content:space-between; gap:1rem; margin-top:2rem; padding-top:1.5rem; border-top:1px solid #e5e7eb; flex-wrap:wrap;">
                <button type="button" id="payment-resetFilters" style="background:transparent; color:#6b7280; padding:0.625rem 1.25rem; border:1px solid #d1d5db; border-radius:8px; cursor:pointer; font-weight:500; font-size:0.875rem; transition:all 0.2s;" 
                    onmouseover="this.style.background='#f3f4f6';" 
                    onmouseout="this.style.background='transparent';">
                    Reset
                </button>
                <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                    <button type="button" id="payment-exportCsv" style="background:#1a1a1a; color:white; padding:0.625rem 1.25rem; border:none; border-radius:8px; cursor:pointer; font-weight:500; font-size:0.875rem; transition:all 0.2s; display:flex; align-items:center; gap:0.5rem;" 
                        onmouseover="this.style.background='#000';" 
                        onmouseout="this.style.background='#1a1a1a';">
                        <i class="fas fa-file-export"></i> Export CSV
                    </button>
                    <button type="button" id="payment-applyFilters" style="background:linear-gradient(135deg, #ff8c00, #ff6600); color:white; padding:0.625rem 1.5rem; border:none; border-radius:8px; cursor:pointer; font-weight:500; font-size:0.875rem; box-shadow:0 2px 4px rgba(255,140,0,0.3); transition:all 0.2s; display:flex; align-items:center; gap:0.5rem;" 
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(255,140,0,0.4)';" 
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(255,140,0,0.3)';">
                        <i class="fas fa-filter"></i> Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Scoped styles for payment records only */
    .payment-records-wrapper #payment-searchBox:focus {
        outline:none;
        border-color:#ff8c00;
        box-shadow:0 0 0 3px rgba(255,140,0,0.1);
    }
    .payment-records-wrapper select:focus, 
    .payment-records-wrapper input[type="date"]:focus, 
    .payment-records-wrapper input[type="number"]:focus {
        outline:none;
        border-color:#ff8c00;
        box-shadow:0 0 0 3px rgba(255,140,0,0.1);
    }
</style>

<script>
(function() {
    // Wrap everything in IIFE to avoid global scope pollution
    const rows = Array.from(document.querySelectorAll("#payment-paymentTableBody tr"));
    let currentPage = 1;
    let recordsPerPage = 20;
    let filteredRows = [...rows];

    function getActiveFilters() {
        return {
            search: document.getElementById("payment-searchBox").value.toLowerCase(),
            status: document.getElementById("payment-status").value,
            gateway: document.getElementById("payment-gateway").value,
            dateFrom: document.getElementById("payment-dateFrom").value,
            dateTo: document.getElementById("payment-dateTo").value,
            min: parseFloat(document.getElementById("payment-amountMin").value) || 0,
            max: parseFloat(document.getElementById("payment-amountMax").value) || Infinity
        };
    }

    function updateActiveFiltersDisplay() {
        const filters = getActiveFilters();
        const filterTagsContainer = document.getElementById("payment-filterTags");
        const activeFiltersDiv = document.getElementById("payment-activeFilters");
        filterTagsContainer.innerHTML = "";
        
        let hasFilters = false;
        
        if (filters.status) {
            hasFilters = true;
            filterTagsContainer.innerHTML += `<span style="background:#ff8c00; color:white; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:500;">Status: ${filters.status}</span>`;
        }
        if (filters.gateway) {
            hasFilters = true;
            filterTagsContainer.innerHTML += `<span style="background:#ff8c00; color:white; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:500;">Gateway: ${filters.gateway}</span>`;
        }
        if (filters.dateFrom) {
            hasFilters = true;
            filterTagsContainer.innerHTML += `<span style="background:#ff8c00; color:white; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:500;">From: ${filters.dateFrom}</span>`;
        }
        if (filters.dateTo) {
            hasFilters = true;
            filterTagsContainer.innerHTML += `<span style="background:#ff8c00; color:white; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:500;">To: ${filters.dateTo}</span>`;
        }
        if (filters.min > 0) {
            hasFilters = true;
            filterTagsContainer.innerHTML += `<span style="background:#ff8c00; color:white; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:500;">Min: ₦${filters.min.toLocaleString()}</span>`;
        }
        if (filters.max < Infinity) {
            hasFilters = true;
            filterTagsContainer.innerHTML += `<span style="background:#ff8c00; color:white; padding:0.375rem 0.75rem; border-radius:8px; font-size:0.75rem; font-weight:500;">Max: ₦${filters.max.toLocaleString()}</span>`;
        }
        
        activeFiltersDiv.style.display = hasFilters ? "block" : "none";
    }

    function updateStats() {
        let totalAmount = 0;
        let totalPayments = 0;
        let successfulPayments = 0;
        
        filteredRows.forEach(row => {
            const amtText = row.children[3].textContent;
            const amount = parseFloat(amtText.replace(/[₦,]/g, "")) || 0;
            const status = row.children[4].textContent.toLowerCase().trim();
            
            totalAmount += amount;
            totalPayments++;
            if (status === 'success') {
                successfulPayments++;
            }
        });
        
        document.getElementById("payment-displayTotalAmount").textContent = `₦${totalAmount.toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        document.getElementById("payment-displayTotalPayments").textContent = totalPayments;
        document.getElementById("payment-displaySuccessfulPayments").textContent = successfulPayments;
    }

    function filterTable() {
        const filters = getActiveFilters();
        filteredRows = [];

        rows.forEach(row => {
            const [ref, pack, gate, amtText, stat, date] = row.children;
            const amount = parseFloat(amtText.textContent.replace(/[₦,]/g, "")) || 0;

            const matchSearch = filters.search === "" || row.textContent.toLowerCase().includes(filters.search);
            const matchStatus = !filters.status || stat.textContent.toLowerCase().includes(filters.status);
            const matchGateway = !filters.gateway || gate.textContent.toLowerCase().includes(filters.gateway);
            const matchDate = (!filters.dateFrom || date.textContent >= filters.dateFrom) && 
                             (!filters.dateTo || date.textContent <= filters.dateTo);
            const matchAmount = amount >= filters.min && amount <= filters.max;

            if (matchSearch && matchStatus && matchGateway && matchDate && matchAmount) {
                filteredRows.push(row);
            }
        });
        
        currentPage = 1;
        updateStats();
        updateActiveFiltersDisplay();
        displayPage();
    }

    function displayPage() {
        const start = (currentPage - 1) * recordsPerPage;
        const end = start + recordsPerPage;
        
        rows.forEach(row => row.style.display = "none");
        
        const pageRows = filteredRows.slice(start, end);
        pageRows.forEach(row => row.style.display = "");
        
        const hasResults = filteredRows.length > 0;
        document.getElementById("payment-paymentTable").style.display = hasResults ? "" : "none";
        document.getElementById("payment-noResults").style.display = hasResults ? "none" : "block";
        
        updatePaginationControls();
    }

    function updatePaginationControls() {
        const totalRecords = filteredRows.length;
        const totalPages = Math.ceil(totalRecords / recordsPerPage);
        const start = totalRecords > 0 ? (currentPage - 1) * recordsPerPage + 1 : 0;
        const end = Math.min(currentPage * recordsPerPage, totalRecords);
        
        document.getElementById("payment-showingStart").textContent = start;
        document.getElementById("payment-showingEnd").textContent = end;
        document.getElementById("payment-totalRecords").textContent = totalRecords;
        
        document.getElementById("payment-prevPage").disabled = currentPage === 1;
        document.getElementById("payment-nextPage").disabled = currentPage === totalPages || totalPages === 0;
        
        document.getElementById("payment-prevPage").style.opacity = currentPage === 1 ? "0.5" : "1";
        document.getElementById("payment-nextPage").style.opacity = (currentPage === totalPages || totalPages === 0) ? "0.5" : "1";
        document.getElementById("payment-prevPage").style.cursor = currentPage === 1 ? "not-allowed" : "pointer";
        document.getElementById("payment-nextPage").style.cursor = (currentPage === totalPages || totalPages === 0) ? "not-allowed" : "pointer";
        
        const pageNumbersDiv = document.getElementById("payment-pageNumbers");
        pageNumbersDiv.innerHTML = "";
        
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage < maxVisiblePages - 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement("button");
            btn.textContent = i;
            btn.style.cssText = `
                padding:0.5rem 0.75rem;
                border:1px solid ${i === currentPage ? '#ff8c00' : '#e5e7eb'};
                background:${i === currentPage ? '#ff8c00' : 'white'};
                color:${i === currentPage ? 'white' : '#374151'};
                border-radius:8px;
                cursor:pointer;
                font-size:0.875rem;
                font-weight:${i === currentPage ? '600' : '400'};
                transition:all 0.2s;
            `;
            btn.addEventListener("click", () => {
                currentPage = i;
                displayPage();
            });
            btn.addEventListener("mouseover", function() {
                if (i !== currentPage) {
                    this.style.background = '#f9fafb';
                }
            });
            btn.addEventListener("mouseout", function() {
                if (i !== currentPage) {
                    this.style.background = 'white';
                }
            });
            pageNumbersDiv.appendChild(btn);
        }
    }

    // Search functionality
    document.getElementById("payment-searchBox").addEventListener("input", filterTable);

    // Pagination controls
    document.getElementById("payment-prevPage").addEventListener("click", () => {
        if (currentPage > 1) {
            currentPage--;
            displayPage();
        }
    });

    document.getElementById("payment-nextPage").addEventListener("click", () => {
        const totalPages = Math.ceil(filteredRows.length / recordsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayPage();
        }
    });

    document.getElementById("payment-recordsPerPage").addEventListener("change", (e) => {
        recordsPerPage = parseInt(e.target.value);
        currentPage = 1;
        displayPage();
    });

    // Apply filters
    document.getElementById("payment-applyFilters").addEventListener("click", () => {
        filterTable();
        document.getElementById("payment-filterModal").style.display = "none";
    });

    // Reset filters
    document.getElementById("payment-resetFilters").addEventListener("click", () => {
        document.getElementById("payment-status").value = "";
        document.getElementById("payment-gateway").value = "";
        document.getElementById("payment-dateFrom").value = "";
        document.getElementById("payment-dateTo").value = "";
        document.getElementById("payment-amountMin").value = "";
        document.getElementById("payment-amountMax").value = "";
    });

    // Clear all filters
    document.getElementById("payment-clearFilters").addEventListener("click", () => {
        document.getElementById("payment-searchBox").value = "";
        document.getElementById("payment-status").value = "";
        document.getElementById("payment-gateway").value = "";
        document.getElementById("payment-dateFrom").value = "";
        document.getElementById("payment-dateTo").value = "";
        document.getElementById("payment-amountMin").value = "";
        document.getElementById("payment-amountMax").value = "";
        filterTable();
    });

    // Export filtered data to CSV
    document.getElementById("payment-exportCsv").addEventListener("click", () => {
        const filters = getActiveFilters();
        let csv = "Reference,Package,Gateway,Amount,Status,Date\n";
        let exportCount = 0;
        
        filteredRows.forEach(row => {
            const cols = Array.from(row.children).map(td => {
                let text = td.textContent.trim();
                text = text.replace(/\s+/g, ' ');
                if (text.includes(',') || text.includes('"')) {
                    text = '"' + text.replace(/"/g, '""') + '"';
                }
                return text;
            });
            csv += cols.join(",") + "\n";
            exportCount++;
        });
        
        if (exportCount === 0) {
            alert("No data to export. Please adjust your filters.");
            return;
        }
        
        const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        
        const date = new Date().toISOString().split('T')[0];
        let filename = `payments_${date}`;
        if (filters.status) filename += `_${filters.status}`;
        if (filters.gateway) filename += `_${filters.gateway}`;
        a.download = `${filename}.csv`;
        
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        document.getElementById("payment-filterModal").style.display = "none";
    });

    // Modal toggling
    document.getElementById("payment-openFilterModal").addEventListener("click", () => {
        document.getElementById("payment-filterModal").style.display = "flex";
    });

    document.getElementById("payment-closeFilterModalX").addEventListener("click", () => {
        document.getElementById("payment-filterModal").style.display = "none";
    });

    // Close modal when clicking outside
    document.getElementById("payment-filterModal").addEventListener("click", (e) => {
        if (e.target.id === "payment-filterModal") {
            document.getElementById("payment-filterModal").style.display = "none";
        }
    });

    // Initialize on page load
    filterTable();
})();
</script>
@endsection