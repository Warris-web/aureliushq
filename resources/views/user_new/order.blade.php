@extends('user_new.app')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold fs-4">My Orders</h2>
        <a href="{{ route('user.packages') }}" class="text-decoration-none small fw-semibold text-primary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="orders-list">
            @foreach($orders as $order)
                <div class="order-card p-3 rounded shadow-sm bg-white">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0 fw-bold text-dark">#{{ $order->order_number }}</h6>
                        <span class="badge rounded-pill px-3 py-1 
                            @switch($order->status)
                                @case('pending') bg-warning text-dark @break
                                @case('Approved') bg-success text-white @break
                                @case('preparing') bg-danger text-white @break
                                @case('ready') bg-info text-white @break
                                @case('delivered') bg-success text-white @break
                                @case('cancelled') bg-secondary text-white @break
                                @default bg-light text-dark
                            @endswitch">
                            @switch($order->status)
                                @case('pending') <i class="fas fa-clock me-1"></i> Under Review @break
                                @case('Approved') <i class="fas fa-check-circle me-1"></i> Approved @break
                                @case('preparing') <i class="fas fa-fire me-1"></i> Preparing @break
                                @case('ready') <i class="fas fa-truck me-1"></i> Dispatched @break
                                @case('delivered') <i class="fas fa-box-open me-1"></i> Delivered @break
                                @case('cancelled') <i class="fas fa-times-circle me-1"></i> Denied @break
                                @default Unknown
                            @endswitch
                        </span>
                    </div>

                    <!-- Meta Info -->
                    <div class="small text-muted mb-2">
                        <div><i class="fas fa-calendar me-1"></i> {{ $order->created_at->format('M j, Y g:i A') }}</div>
                        <div><i class="fas fa-naira-sign me-1"></i> ₦{{ number_format($order->total_amount, 2) }}</div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.orders.show', $order->order_number) }}" 
                           class="btn btn-sm btn-outline-primary flex-fill">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>

                        @if($order->status === 'pending')
                            <button class="btn btn-sm btn-outline-danger flex-fill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteOrderModal_{{ $order->id }}">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteOrderModal_{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">Delete Order</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="mb-0">Are you sure you want to delete order <strong>#{{ $order->order_number }}</strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('user.orders.delete', $order->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Confirm Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state text-center p-5">
            <h5 class="fw-bold text-secondary mb-2">No Orders Yet</h5>
            <p class="text-muted small mb-3">Your delicious journey starts here. Place your first order and it will show up below.</p>
            <a href="{{ route('user.packages') }}" 
               class="btn btn-primary px-3 py-2 rounded-pill shadow-sm btn-sm">
                <i class="fas fa-shopping-cart me-1"></i> Start Shopping
            </a>
        </div>
    @endif
</div>

<style>
    .order-card {
        border: 1px solid #f0f0f0;
        transition: all 0.2s ease-in-out;
    }
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .empty-state {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        max-width: 420px;
        margin: 3rem auto;
    }
    @media (max-width: 576px) {
        .order-card h6 {
            font-size: 1rem;
        }
        .order-card .small {
            font-size: 0.85rem;
        }
        .btn-sm {
            font-size: 0.9rem;
        }
    }
</style>
@endsection
