@extends('user.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary-color: #6366f1;
        --primary-dark: #4338ca;
        --success-color: #10b981;
        --success-dark: #059669;
        --danger-color: #ef4444;
        --danger-dark: #dc2626;
        --warning-color: #f59e0b;
        --warning-dark: #d97706;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --bg-primary: #ffffff;
        --bg-secondary: #f9fafb;
        --bg-tertiary: #f3f4f6;
        --border-color: #e5e7eb;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }

    /* Header */
    .header {
        background: var(--bg-primary);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 0;
        position: sticky;
        top: 0;
        z-index: 100;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .logo {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-container {
        flex: 1;
        max-width: 500px;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-lg);
        font-size: 1rem;
        transition: all 0.2s ease;
        background: var(--bg-primary);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        width: 1.25rem;
        height: 1.25rem;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .orders-btn {
        background: var(--warning-color);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        text-decoration: none;
    }

    .orders-btn:hover {
        background: var(--warning-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }

    .cart-trigger {
        position: relative;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .cart-trigger:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-lg);
    }

    .cart-badge {
        position: absolute;
        top: -0.5rem;
        right: -0.5rem;
        background: var(--danger-color);
        color: white;
        border-radius: 50%;
        width: 1.25rem;
        height: 1.25rem;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        min-width: 1.25rem;
    }

    /* Cart Sidebar */
    .cart-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 200;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .cart-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .cart-sidebar {
        position: fixed;
        top: 0;
        right: -400px;
        width: 400px;
        height: 100vh;
        background: var(--bg-primary);
        box-shadow: var(--shadow-lg);
        z-index: 300;
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .cart-sidebar.active {
        right: 0;
    }

    .cart-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cart-title {
        font-size: 1.25rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cart-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--text-secondary);
        padding: 0.25rem;
        border-radius: var(--radius-sm);
        transition: all 0.2s ease;
    }

    .cart-close:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }

    .cart-content {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    .cart-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--text-secondary);
    }

    .cart-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        margin-bottom: 0.75rem;
        background: var(--bg-primary);
        transition: all 0.2s ease;
    }

    .cart-item:hover {
        box-shadow: var(--shadow-md);
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .cart-item-price {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .cart-item-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .qty-control {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        overflow: hidden;
    }

    .qty-btn {
        background: var(--bg-tertiary);
        border: none;
        padding: 0.5rem;
        cursor: pointer;
        transition: background 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
    }

    .qty-btn:hover {
        background: var(--border-color);
    }

    .qty-input {
        border: none;
        width: 3rem;
        text-align: center;
        padding: 0.5rem 0;
        font-weight: 600;
    }

    .remove-btn {
        background: var(--danger-color);
        color: white;
        border: none;
        border-radius: var(--radius-sm);
        padding: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
    }

    .remove-btn:hover {
        background: var(--danger-dark);
        transform: scale(1.05);
    }

    .cart-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-secondary);
    }

    .cart-total {
        font-size: 1.25rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .cart-limit {
        font-size: 0.875rem;
        color: var(--text-secondary);
        text-align: center;
        margin-bottom: 1rem;
    }

    .checkout-btn {
        width: 100%;
        background: var(--success-color);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        padding: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 1rem;
    }

    .checkout-btn:hover {
        background: var(--success-dark);
        transform: translateY(-1px);
    }

    .checkout-btn:disabled {
        background: var(--text-secondary);
        cursor: not-allowed;
        transform: none;
    }

    /* Main Content */
    .main-content {
        padding: 2rem 0;
    }

    .section-header {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .section-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .product-card {
        background: var(--bg-primary);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: var(--bg-tertiary);
    }

    .product-info {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.75rem;
    }

    .product-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        flex: 1;
        margin-bottom: 1rem;
    }

    .product-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: auto;
    }

    .product-qty {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .product-qty button {
        background: var(--bg-tertiary);
        border: none;
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: background 0.2s ease;
        font-weight: 600;
    }

    .product-qty button:hover {
        background: var(--border-color);
    }

    .product-qty input {
        border: none;
        width: 3rem;
        text-align: center;
        padding: 0.5rem 0;
        font-weight: 600;
    }

    .add-to-cart-btn {
        flex: 1;
        background: var(--success-color);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .add-to-cart-btn:hover {
        background: var(--success-dark);
        transform: translateY(-1px);
    }

    .add-to-cart-btn:active {
        transform: translateY(0);
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Alerts */
    .alert {
        position: fixed;
        top: 1rem;
        right: 1rem;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        color: white;
        font-weight: 600;
        z-index: 1000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 300px;
    }

    .alert.show {
        transform: translateX(0);
    }

    .alert.error {
        background: var(--danger-color);
    }

    .alert.success {
        background: var(--success-color);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
        }

        .search-container {
            order: 2;
            max-width: none;
        }

        .header-actions {
            order: 1;
            align-self: flex-end;
        }

        .cart-sidebar {
            width: 100vw;
            right: -100vw;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .section-title {
            font-size: 1.75rem;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .product-card {
        animation: fadeIn 0.5s ease forwards;
    }

    /* Category badge */
.category-wrapper {
    position: relative;
    display: inline-block; /* keeps image + badge aligned */
}

.category-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(135deg, #ff7b00, #ff4500);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    z-index: 10;
}

/* Product image wrapper with overlay button */
.product-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
}

.product-image {
    width: 100%;
    display: block;
    border-radius: 10px;
}

/* Eye button */
.view-details-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    font-size: 16px;
    padding: 6px 10px;
    border-radius: 50%;
    transition: all 0.3s ease;
    opacity: 0;
}

.product-image-wrapper:hover .view-details-btn {
    opacity: 1;
    transform: scale(1.1);
}

</style>


<div class="container">
    <div class="main-content">
        <div class="section-header">
            <a class="btn btn-primary" href="{{ route('user.packages') }}" >Go Back</a><span class="section-title">  Food Market (<span style="color:darkorange;" class="text-primary">@if($query)
    You searched for: <strong>{{ $query }}</strong>
@endif
</span>)</span>
        </div>

       <div class="container my-5">
    
</div>

      <div class="product-grid" id="productGrid">


        @if (count($foods) > 0)

    @foreach($foods as $food)
        <div class="product-card" data-name="{{ strtolower($food->name) }}">
            
            {{-- Category Badge --}}
               <span class="category-badge">
                    {{ optional($food->cat)->name }}
                </span>
                
            <div class="product-image-wrapper">
                <img src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                     alt="{{ $food->name }}" class="product-image">
                
                {{-- Eye Icon for Modal --}}
                <button type="button" 
                        class="view-details-btn" 
                        data-bs-toggle="modal" 
                        data-bs-target="#foodModal-{{ $food->id }}">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            
            <div class="product-info">
                <h3 class="product-name">{{ $food->name }}</h3>
                <div class="product-price">₦{{ number_format($food->amount, 2) }}</div>
                
                <div class="product-actions">
                    <div class="product-qty">
                        <button type="button" onclick="changeQty({{ $food->id }}, -1)">−</button>
                        <input type="number" min="1" value="1" id="qty-{{ $food->id }}" class="qty-input-product" readonly>
                        <button type="button" onclick="changeQty({{ $food->id }}, 1)">+</button>
                    </div>
                    <button 
                        onclick="addToCart({{ $food->id }}, '{{ addslashes($food->name) }}', {{ $food->amount }})"
                        class="add-to-cart-btn">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal for Food Details --}}
        <div class="modal fade" id="foodModal-{{ $food->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $food->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                                     alt="{{ $food->name }}" class="img-fluid rounded">
                            </div>
                            <div class="col-md-7">
                                <h4>₦{{ number_format($food->amount, 2) }}</h4>
                                <p>{{ $food->description ?? $food->short_description }}</p>
                                
                                @if($food->cat)
                                    <span class="category-badge">{{ $food->cat->name }}</span>
                                @endif

                                <div class="mt-3">
                                    <button 
                                        onclick="addToCart({{ $food->id }}, '{{ addslashes($food->name) }}', {{ $food->amount }})"
                                        class="btn btn-success">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @else
<div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 50vh;">
    <div class="text-center p-5 border rounded-4 shadow-sm bg-light" style="max-width: 500px;">
        <div class="mb-3">
            <i class="fas fa-box-open fa-4x text-muted"></i>
        </div>
        <h4 class="fw-bold text-secondary">No Products Found</h4>
        <p class="text-muted">This Search Query is empty for now. Please check back later for amazing updates 🌟</p>
        <a href="{{ route('user.packages') }}" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left me-2"></i> Go Back
        </a>
    </div>
</div>

      @endif
    
</div>

    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let cart = [];
let totalAmount = 0;
const LIMIT = 50000;
let isLoading = false;

// Get CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Load cart from server on page load

// Save cart to server
async function saveCart() {
    try {
        const response = await fetch('cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ items: cart })
        });
        
        return response.ok;
    } catch (error) {
        console.error('Failed to save cart:', error);
        return false;
    }
}


function showAlert(message, type = 'error') {
    const alert = document.createElement('div');
    alert.className = `alert ${type}`;
    alert.textContent = message;
    document.body.appendChild(alert);
    
    setTimeout(() => alert.classList.add('show'), 100);
    setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => document.body.removeChild(alert), 300);
    }, 3000);
}

async function addToCart(id, name, price) {
    const qty = parseInt(document.getElementById(`qty-${id}`).value) || 1;

    const response = await fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ id, name, price, qty })
    });

    const result = await response.json();

    if (result.success) {
        showAlert(result.message, "success");
        // optionally re-render cart items dynamically
    } else {
        showAlert(result.message, "error");
    }

    document.getElementById(`qty-${id}`).value = 1;
}






</script>
@endsection