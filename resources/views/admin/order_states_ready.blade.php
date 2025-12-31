@extends('admin.app')

@section('content')
<div class="container-fluid py-4">

<div class="mb-3">
<button style="mb-2" type="button" class="btn btn-dark" onclick="window.history.back()">
    <i class="fa fa-arrow-left"></i> Go Back
</button>
</div>

    <!-- ====== TOTAL SALES SUMMARY ====== -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
    
        <div class="card-body">
            <h5 class="fw-bold text-dark mb-3">
                <i class="fas fa-chart-line me-2 text-primary"></i> Total Sales Summary
            </h5>

            <div class="d-flex flex-wrap gap-3">
                <!-- Total Orders -->
                <div class="summary-box bg-light border rounded p-3">
                    <strong>Total Orders:</strong> {{ $totalOrders }}
                </div>

                <!-- Dynamic Status Summary -->
                @foreach($statusSummary as $status => $count)
                    <div class="summary-box p-3 rounded text-white
                        @switch($status)
                            @case('pending') bg-warning @break
                            @case('Approved') bg-info @break
                            @case('preparing') bg-primary @break
                            @case('ready') bg-secondary @break
                            @case('delivered') bg-success @break
                            @case('cancelled') bg-danger @break
                            @default bg-dark
                        @endswitch">
                        <strong>{{ ucfirst($status) }}:</strong> {{ $count }}
                    </div>
                @endforeach

                <!-- Total Sales Value -->
                <div class="summary-box bg-dark text-white p-3 rounded">
                    <strong>Total Sales:</strong> ₦{{ number_format($totalSalesValue, 2) }}
                </div>
            </div>
        </div>
    </div>

    <style>
    .summary-box {
        min-width: 160px;
        text-align: center;
        font-size: 0.95rem;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    </style>
    <!-- ====== END SUMMARY ====== -->

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Manage State Dispatched Orders (<span style="color:darkorange">{{ $name }}</span>)</h3>
        <input type="text" id="searchInput" class="form-control shadow-sm"
               placeholder="Search orders..."
               style="max-width: 280px; border-radius: 30px;">
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded-pill px-4 py-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded-pill px-4 py-2">{{ session('error') }}</div>
    @endif

    <!-- Orders Table -->
    @if($orders->count() > 0)
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="ordersTable">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Order Number</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center" width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td class="fw-semibold">{{ $index + 1 }}</td>
                                    <td><span class="badge bg-dark text-white px-3">{{ $order->order_number }}</span></td>
                                    <td>{{ $order->created_at->format('M j, Y g:i A') }}</td>
                                    <td>{{ count($order->items) }} item(s)</td>
                                    <td class="fw-bold text-success">₦{{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge
                                            @if($order->status == 'pending') bg-warning text-white
                                            @elseif($order->status == 'Approved') bg-info
                                            @elseif($order->status == 'preparing') bg-primary
                                            @elseif($order->status == 'ready') bg-secondary
                                            @elseif($order->status == 'delivered') bg-success
                                            @elseif($order->status == 'cancelled') bg-danger
                                            @endif
                                            px-3 py-2 rounded-pill">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.orders.show', $order->order_number) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill me-2">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <button
                                            class="btn btn-sm btn-outline-warning rounded-pill change-status-btn"
                                            data-order="{{ $order->id }}"
                                            data-status="{{ $order->status }}">
                                            <i class="fas fa-edit"></i> Status
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div id="pagination" class="d-flex justify-content-center p-3"></div>

            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h4 class="fw-bold text-secondary mt-3">No Orders Yet</h4>
            <p class="text-muted">Orders you receive will appear here.</p>
        </div>
    @endif
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.update.order') }}" class="w-100">
        @csrf
        <input type="hidden" name="order_id" id="modal_order_id">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Change Order Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="status" class="form-label fw-semibold">Select Status</label>
                <select class="form-select shadow-sm rounded-pill" name="status" id="modal_status">
                    <option value="pending">Under Review</option>
                    <option value="Approved">Approved</option>
                    <option value="preparing">Preparing</option>
                    <option value="ready">Dispatched</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Denied</option>
                </select>
                

                <label for="reason" class="form-label fw-semibold mt-3">Reason</label>
                <textarea class="form-control shadow-sm rounded-3" name="reason" id="modal_reason" rows="3" placeholder="Enter reason..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success rounded-pill px-4">Update</button>
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));

    document.querySelectorAll('.change-status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('modal_order_id').value = this.dataset.order;
            document.getElementById('modal_status').value = this.dataset.status;
            modal.show();
        });
    });

    const rowsPerPage = 20;
    const tableBody = document.querySelector("#ordersTable tbody");
    const rows = Array.from(tableBody.querySelectorAll("tr"));
    const pagination = document.getElementById("pagination");
    const searchInput = document.getElementById("searchInput");
    let currentPage = 1;
    let filteredRows = [...rows];

    function displayRows() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        filteredRows.forEach((row, index) => {
            row.style.display = (index >= start && index < end) ? "" : "none";
        });
    }

    function setupPagination() {
        pagination.innerHTML = "";
        const pageCount = Math.ceil(filteredRows.length / rowsPerPage);

        if (pageCount <= 1) {
            pagination.style.display = 'none';
            return;
        }
        pagination.style.display = 'flex';

        for (let i = 1; i <= pageCount; i++) {
            const btn = document.createElement("button");
            btn.innerText = i;
            btn.className = "btn btn-sm mx-1 rounded-pill " + (i === currentPage ? "btn-primary" : "btn-outline-primary");
            btn.addEventListener("click", () => {
                currentPage = i;
                displayRows();
                setupPagination();
            });
            pagination.appendChild(btn);
        }
    }

    function filterRows() {
        const searchText = searchInput.value.toLowerCase();
        filteredRows = rows.filter(row => row.innerText.toLowerCase().includes(searchText));
        currentPage = 1;
        rows.forEach(row => row.style.display = "none");
        displayRows();
        setupPagination();
    }

    displayRows();
    setupPagination();
    searchInput.addEventListener("keyup", filterRows);
});
</script>
@endsection
