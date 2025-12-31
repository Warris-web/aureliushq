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
</style>

{{-- <div class="header">
    <div class="container">
        <div class="header-content">
            <div class="search-container">
                <div class="search-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="searchInput" class="search-input" placeholder="Search delicious food...">
            </div>

            <div class="header-actions">
                <a href="" class="orders-btn">
                    <i class="fas fa-receipt"></i> My Orders
                </a>
                <button class="cart-trigger" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart"></i> Cart
                    <span class="cart-badge" id="cart-badge" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </div>
</div> --}}

<div class="cart-overlay" id="cart-overlay"></div>
<div class="cart-sidebar" id="cart-sidebar">
    <div class="cart-header">
        <div class="cart-title">🛒 Your Cart</div>
        <button class="cart-close" onclick="toggleCart()">×</button>
    </div>
    
    <div class="cart-content">
        <div class="cart-empty" id="cart-empty">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🛒</div>
            <p>Your cart is empty</p>
            <small>Add some delicious items to get started!</small>
        </div>
        <div id="cart-items"></div>
    </div>
    
    <div class="cart-footer" id="cart-footer" style="display: none;">
        <div class="cart-total">
            Total: ₦<span id="cart-total">0</span>
        </div>
        <div class="cart-limit">
            Limit: ₦<span id="remaining-limit">50,000</span> remaining
        </div>
        <button class="checkout-btn" id="checkout-btn" onclick="checkout()">
            <i class="fas fa-credit-card"></i>
            Checkout
        </button>
    </div>
</div>

<div class="container">
    <div class="main-content">
        <div class="section-header">
            <h1 class="section-title">Food Market</h1>
            <p class="section-subtitle">Fresh and delicious meals delivered to you</p>
        </div>

        <div class="product-grid" id="productGrid">
            @foreach($foods as $food)
                <div class="product-card" data-name="{{ strtolower($food->name) }}">
                    <img src="{{ $food->image ? asset($food->image) : asset('images/placeholder.png') }}" 
                         alt="{{ $food->name }}" class="product-image">
                    
                    <div class="product-info">
                        <h3 class="product-name">{{ $food->name }}</h3>
                        <div class="product-price">₦{{ number_format($food->amount, 2) }}</div>
                        <p class="product-description">{{ $food->short_description }}</p>
                        
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
            @endforeach
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
async function loadCart() {
    try {
        const response = await fetch('/api/cart', {
            headers: {
                'Authorization': `Bearer {{ auth()->user()->api_token ?? '' }}`,
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            cart = data.items || [];
            recalcTotal();
            renderCart();
        }
    } catch (error) {
        console.error('Failed to load cart:', error);
    }
}

// Save cart to server
async function saveCart() {
    try {
        const response = await fetch('/api/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer {{ auth()->user()->api_token ?? '' }}`,
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

function toggleCart() {
    const overlay = document.getElementById('cart-overlay');
    const sidebar = document.getElementById('cart-sidebar');
    overlay.classList.toggle('active');
    sidebar.classList.toggle('active');
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

function changeQty(id, delta) {
    const input = document.getElementById(`qty-${id}`);
    const currentQty = parseInt(input.value);
    const newQty = Math.max(1, currentQty + delta);
    input.value = newQty;
}

async function addToCart(id, name, price) {
    const qty = parseInt(document.getElementById(`qty-${id}`).value) || 1;
    const itemTotal = qty * price;

    if (totalAmount + itemTotal > LIMIT) {
        showAlert(`❌ Cannot exceed ₦${LIMIT.toLocaleString()}. Current total: ₦${totalAmount.toLocaleString()}`);
        return;
    }

    const existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        const newTotal = (existingItem.qty + qty) * price;
        if (totalAmount - existingItem.total + newTotal > LIMIT) {
            showAlert(`❌ Adding this quantity will exceed the limit`);
            return;
        }
        existingItem.qty += qty;
        existingItem.total = newTotal;
    } else {
        cart.push({ id, name, qty, price, total: itemTotal });
    }

    document.getElementById(`qty-${id}`).value = 1;
    recalcTotal();
    renderCart();
    
    // Save to server
    await saveCart();
    showAlert(`✅ ${name} added to cart!`, 'success');
}

async function updateCartQty(id, newQty) {
    const item = cart.find(i => i.id === id);
    if (!item) return;

    const newTotal = newQty * item.price;
    const diff = newTotal - item.total;
    
    if (totalAmount + diff > LIMIT) {
        showAlert(`❌ Cannot exceed ₦${LIMIT.toLocaleString()}`);
        return;
    }

    if (newQty <= 0) {
        removeFromCart(id);
        return;
    }

    item.qty = newQty;
    item.total = newTotal;
    recalcTotal();
    renderCart();
    
    // Save to server
    await saveCart();
}

async function removeFromCart(id) {
    const index = cart.findIndex(i => i.id === id);
    if (index !== -1) {
        cart.splice(index, 1);
    }
    recalcTotal();
    renderCart();
    
    // Save to server
    await saveCart();
}

function recalcTotal() {
    totalAmount = cart.reduce((sum, item) => sum + item.total, 0);
}

function renderCart() {
    const cartItems = document.getElementById('cart-items');
    const cartEmpty = document.getElementById('cart-empty');
    const cartBadge = document.getElementById('cart-badge');
    const cartTotal = document.getElementById('cart-total');
    const remainingLimit = document.getElementById('remaining-limit');
    const cartFooter = document.getElementById('cart-footer');

    const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
    cartBadge.style.display = totalItems > 0 ? 'flex' : 'none';
    cartBadge.textContent = totalItems;

    if (cart.length === 0) {
        cartEmpty.style.display = 'block';
        cartItems.innerHTML = '';
        cartFooter.style.display = 'none';
    } else {
        cartEmpty.style.display = 'none';
        cartFooter.style.display = 'block';
        cartItems.innerHTML = cart.map(item => `
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">₦${item.price.toLocaleString()} each</div>
                </div>
                <div class="cart-item-controls">
                    <div class="qty-control">
                        <button class="qty-btn" onclick="updateCartQty(${item.id}, ${item.qty - 1})">−</button>
                        <input type="number" class="qty-input" value="${item.qty}" onchange="updateCartQty(${item.id}, parseInt(this.value))">
                        <button class="qty-btn" onclick="updateCartQty(${item.id}, ${item.qty + 1})">+</button>
                    </div>
                    <button class="remove-btn" onclick="removeFromCart(${item.id})">×</button>
                </div>
            </div>
        `).join('');
    }

    cartTotal.textContent = totalAmount.toLocaleString();
    remainingLimit.textContent = (LIMIT - totalAmount).toLocaleString();
}

async function checkout() {
    if (cart.length === 0) {
        showAlert('❌ Your cart is empty!');
        return;
    }

    if (isLoading) return;
    
    isLoading = true;
    const checkoutBtn = document.getElementById('checkout-btn');
    const originalContent = checkoutBtn.innerHTML;
    
    checkoutBtn.innerHTML = '<div class="spinner"></div> Processing...';
    checkoutBtn.disabled = true;
    
    try {
        const response = await fetch('orders/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                items: cart,
                total_amount: totalAmount
            })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            showAlert('🎉 Order placed successfully!', 'success');
            
            // Clear cart
            cart = [];
            recalcTotal();
            renderCart();
            
            // Close cart sidebar
            toggleCart();
            
            // Redirect to orders page after a delay
            setTimeout(() => {
                window.location.href = "{{ route('user.orders') }}";
            }, 2000);
            
        } else {
            showAlert(`❌ ${data.message || 'Checkout failed. Please try again.'}`);
        }
    } catch (error) {
        console.error('Checkout error:', error);
        showAlert('❌ Network error. Please check your connection and try again.');
    } finally {
        isLoading = false;
        checkoutBtn.innerHTML = originalContent;
        checkoutBtn.disabled = false;
    }
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value.toLowerCase().trim();
    const cards = document.querySelectorAll('#productGrid .product-card');
    cards.forEach(card => {
        const name = card.getAttribute('data-name');
        const isVisible = name.includes(query);
        card.style.display = isVisible ? 'flex' : 'none';
        if (isVisible && query) {
            card.style.animation = 'none';
            card.offsetHeight;
            card.style.animation = 'fadeIn 0.3s ease forwards';
        }
    });
});

// Close cart when overlay is clicked
document.getElementById('cart-overlay').addEventListener('click', function() {
    toggleCart();
});

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
});
</script>
@endsection