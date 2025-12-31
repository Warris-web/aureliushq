@extends('admin.app')

@section('content')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #a5b4fc;
        --success-color: #10b981;
        --success-light: #d1fae5;
        --success-dark: #059669;
        --warning-color: #f59e0b;
        --warning-light: #fef3c7;
        --warning-dark: #d97706;
        --danger-color: #ef4444;
        --danger-light: #fee2e2;
        --danger-dark: #dc2626;
        --info-color: #3b82f6;
        --info-light: #dbeafe;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-light: #9ca3af;
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --bg-dark: #0f172a;
        --border-color: #e2e8f0;
        --border-light: #f1f5f9;
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    
    
    /* Container */
    .container {
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Enhanced Payment Header */
    .payment-header {
        position: relative;
        margin-bottom: 3rem;
        padding:1rem;
background: linear-gradient(
    135deg,
    #0f0f0f 0%,
    #1c1c1c 40%,
    #2a2a2a 70%,
    #383838 100%
);
        border-radius: var(--radius-xl);
        color: white;
        overflow: hidden;
    }

    .payment-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 8s infinite linear;
    }

    @keyframes shimmer {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .header-left h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        background: linear-gradient(45deg, #ffffff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .header-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
        font-weight: 400;
    }

    .payment-stats {
        display: flex;
        gap: 2.5rem;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-lg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        min-width: 120px;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        display: block;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
        font-weight: 500;
    }

    /* Enhanced Filter Section */
    .filter-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--bg-primary);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
    }

    .filter-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input {
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--bg-secondary);
        font-size: 0.875rem;
        width: 280px;
        transition: all 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        background: var(--bg-primary);
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        color: var(--text-light);
        pointer-events: none;
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .filter-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .filter-btn:hover::before {
        left: 100%;
    }

    .btn-filter {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn-filter:hover {
        background: linear-gradient(135deg, var(--primary-dark), #312e81);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-reset {
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }

    .btn-reset:hover {
        background: var(--border-color);
        color: var(--text-primary);
        border-color: var(--text-light);
    }

    /* Enhanced Modal */
    .filter-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        backdrop-filter: blur(8px);
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .filter-modal {
        background: white;
        padding: 2.5rem;
        border-radius: var(--radius-xl);
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-xl);
        transform: scale(0.9);
        animation: slideIn 0.3s ease forwards;
    }

    @keyframes slideIn {
        to {
            transform: scale(1);
        }
    }

    .filter-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-light);
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .filter-close {
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--text-light);
        transition: color 0.2s ease;
        padding: 0.5rem;
        border-radius: var(--radius-sm);
    }

    .filter-close:hover {
        color: var(--danger-color);
        background: var(--danger-light);
    }

    /* Enhanced Filters Grid */
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .filter-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .filter-select, .filter-input {
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    /* Enhanced Payments Table */
    .payments-container {
        background: var(--bg-primary);
        border-radius: var(--radius-xl);
        overflow: hidden;
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }

    .payments-table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-header {
        background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-secondary));
        border-bottom: 2px solid var(--border-color);
    }

    .table-header th {
        padding: 1.25rem 1rem;
        text-align: left;
        font-weight: 700;
        color: var(--text-primary);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
    }

    .table-header th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background: var(--border-color);
    }

    .table-row {
        border-bottom: 1px solid var(--border-light);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .table-row:hover {
        background: var(--bg-secondary);
        transform: translateX(2px);
    }

    .table-cell {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .status-success {
        background: var(--success-light);
        color: var(--success-dark);
        border: 1px solid var(--success-color);
    }

    .status-pending {
        background: var(--warning-light);
        color: var(--warning-dark);
        border: 1px solid var(--warning-color);
    }

    .status-failed {
        background: var(--danger-light);
        color: var(--danger-dark);
        border: 1px solid var(--danger-color);
    }

    .status-indicator {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Gateway Badges */
    .gateway-badge {
        padding: 0.25rem 0.75rem;
        background: var(--info-light);
        color: var(--info-color);
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Action Buttons */
    .action-btn {
        padding: 0.5rem;
        border: none;
        border-radius: var(--radius-sm);
        cursor: pointer;
        transition: all 0.2s ease;
        margin-right: 0.5rem;
    }

    .btn-view {
        background: var(--info-light);
        color: var(--info-color);
    }

    .btn-download {
        background: var(--success-light);
        color: var(--success-dark);
    }

    .action-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-sm);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .empty-text {
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .payment-stats {
            justify-content: center;
        }

        .stat-item {
            min-width: 100px;
        }

        .filter-section {
            flex-direction: column;
            gap: 1rem;
        }

        .search-input {
            width: 100%;
        }

        .payments-table {
            font-size: 0.75rem;
        }

        .table-cell {
            padding: 0.75rem 0.5rem;
        }

        .filter-modal {
            width: 95%;
            padding: 1.5rem;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Loading Animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<div class="container">
    <!-- Enhanced Payment Header -->
    <!-- Go Back Button -->
    <!-- Enhanced Payment Header -->
<div class="payment-header">
    <div class="header-content" style="align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ url()->previous() }}" class="filter-btn btn-reset" style="padding:0.5rem 1rem; font-size:0.9rem;">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
            <h3 style="margin:0; font-size:1rem;">Repayment History ( {{ $full_name }} )</h3>
        </div>
    </div>
</div>

    <!-- Enhanced Filter Section -->
    
    <!-- Payments Table -->
    @if($payments && $payments->count() > 0)
        <div class="payments-container">
            <table class="payments-table">
                <thead class="table-header">
                    <tr>
                        <th>Reference</th>
                        <th>Package</th>
                        <th>Gateway</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        {{-- <th>Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr class="table-row">
                            <td class="table-cell">
                                <strong>{{ $payment->reference }}</strong>
                            </td>
                            <td class="table-cell">{{ ucfirst($payment->package) }}</td>
                            <td class="table-cell">
                                <span class="gateway-badge">{{ ucfirst($payment->gateway) }}</span>
                            </td>
                            <td class="table-cell">
                                <strong>₦{{ number_format($payment->amount, 2) }}</strong>
                            </td>
                            <td class="table-cell">
                                <span class="status-badge status-{{ strtolower($payment->status) }}">
                                    <span class="status-indicator"></span>
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="table-cell">{{ $payment->created_at->format('M j, Y g:i A') }}</td>
                            {{-- <td class="table-cell">
                                <button class="action-btn btn-view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
       
    @else
        <div class="payments-container">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3 class="empty-title">No Payment History</h3>
                <p class="empty-text">You haven't made any payments yet. Your transaction history will appear here.</p>
                
            </div>
        </div>
    @endif
</div>


<script>
    // Enhanced Modal Functionality
    const modal = document.getElementById('filterModal');
    const openBtn = document.getElementById('openFilterModal');
    const closeBtn = document.getElementById('closeFilterModal');

    openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // Enhanced Search Functionality
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.table-row');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }, 300);
    });

    // Enhanced Table Row Interactions
    document.querySelectorAll('.table-row').forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('.action-btn')) {
                // Add row selection or detail view functionality here
                this.style.background = 'var(--primary-light)';
                setTimeout(() => {
                    this.style.background = '';
                }, 200);
            }
        });
    });

    // Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            openBtn.click();
        }
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeBtn.click();
        }
    });
</script>
@endsection