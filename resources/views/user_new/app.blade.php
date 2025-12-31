<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from themes.pixelstrap.com/fuzzy/landing.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Sep 2025 07:34:41 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="fuzzy" />
    <meta name="keywords" content="fuzzy" />
    <meta name="author" content="fuzzy" />
    <link rel="manifest" href="manifest.json" />
    {{-- <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon" /> --}}
    <title>Aurelius Dashboard</title>
    {{-- <link rel="apple-touch-icon" href="assets/images/logo/favicon.png" /> --}}
    <meta name="theme-color" content="#122636" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="fuzzy" />
    {{-- <meta name="msapplication-TileImage" content="assets/images/logo/favicon.png" /> --}}

    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
      crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- iconsax css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/iconsax.css') }}" />

    <!-- swiper css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/swiper-bundle.min.css') }}" />

    <!-- bootstrap css -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.min.css') }}" />
    <!-- Theme css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="{{ asset('assets/css/style.css') }}" />
  </head>

<style>
.bg-warning{
  background-color:darkorange !important;
}




</style>
<style>
   .modal {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
}

.modal-body {
    -webkit-overflow-scrolling: touch;
    overflow-y: auto;
}

/* Only apply cursor behavior */
button, label, input[type="radio"] {
    cursor: pointer;
}

</style>


<style>
    button, label, input[type="radio"] {
        cursor: pointer;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.setAttribute('data-bs-backdrop', 'static');
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('button.btn-close[data-bs-dismiss="modal"]').forEach(btn => {
        btn.style.display = 'none';
    });
});
</script>


  <body>
    <!-- side bar start -->
    <div class="offcanvas sidebar-offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft">
      <div class="offcanvas-header">

        <img class="" style="width:70px; height:70px; border-radius:100%;" src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQuWnBi14T_ynO92D9yJX_F6IJocVAd5q3pZA&s') }}" alt="profile" />
        <h4>Hello, {{ Auth::user()->first_name }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="sidebar-content">
          <ul class="link-section">
            
      <li>
  <a href="{{ route('profile') }}" class="pages {{ request()->routeIs('profile') ? 'active' : '' }}">
    <h4>My Profile</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>
      

<li>
  <a href="{{ route('user.packages') }}" class="pages {{ request()->routeIs('user.packages') ? 'active' : '' }}">
    <h4>Food Market</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="{{ route('user.orders') }}" class="pages {{ request()->routeIs('user.orders') ? 'active' : '' }}">
    <h4>My Orders</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>
<li>
  <a href="{{ route('user.referral') }}" class="pages {{ request()->routeIs('user.referral') ? 'active' : '' }}">
    <h4>My Referrals</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="{{ route('user.loan') }}" class="pages {{ request()->routeIs('user.loan') ? 'active' : '' }}">
    <h4>Outstanding History</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>


<li>
  <a href="{{ route('user.payment') }}" class="pages {{ request()->routeIs('user.payment') ? 'active' : '' }}">
    <h4>Payment History</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="{{ route('terms') }}" class="pages {{ request()->routeIs('terms') ? 'active' : '' }}">
    <h4>Terms & Condition</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
</li>

<li>
  <a href="#" class="pages"
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <h4>Logout</h4>
    <i class="ri-arrow-drop-right-line"></i>
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
      @csrf
  </form>
</li>

          </ul>
<!-- ✅ Make sure this is in your <head> -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  integrity="sha512-M9Kc3eVQtrHz9s4yUlPc8aSZoMGU4L7wVkZ7HkS7Zbl5dM+VLQHP1vDfw+PQHMeK0g5Ut0HDI4mK3jLzt7ib2A=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>

<div class="support-section">
  <div class="support-line">
    <a href="{{ platform_settings('support_phone') ?? '!#' }}" class="support-btn call">
      <i class="fa-solid fa-phone me-2"></i> Toll-Free
    </a>

    <a href="{{ route('support.index') }}" class="support-page {{ request()->routeIs('support.index') ? 'active' : '' }}">
      <h4>Support</h4>
      <i class="ri-arrow-drop-right-line"></i>
    </a>

    <a href="mailto:{{ platform_settings('support_email') ?? 'support@aurelius.com' }}" class="support-btn email">
      <i class="fa-solid fa-headset me-2"></i> Direct Support
    </a>

    <span class="support-location">
      <i class="fa-solid fa-location-dot text-orange me-2"></i>
      {{ platform_settings('support_location') ?? 'Ikeja, Lagos' }}
    </span>

    <a style="text-decoration:underline; color:black;" href="{{ route('user.locations') }}">View All Locations</a>
  </div>

  <div class="social-icons">
    <a href="{{ platform_settings('social_facebook') ?? '#' }}"><i class="fa-brands fa-facebook-f"></i></a>
    <a href="{{ platform_settings('social_x_tiktok') ?? '#' }}"><i class="fa-brands fa-x-twitter"></i></a>
    <a href="{{ platform_settings('social_instagram') ?? '#' }}"><i class="fa-brands fa-instagram"></i></a>
  </div>
</div>

<style>
/* Main Section */
.support-section {
  background: #fff7f4; /* Light orange tone */
  border-radius: 16px;
  padding: 2rem 1rem;
  box-shadow: 0 4px 16px rgba(0,0,0,0.05);
  margin: 2rem auto;
  max-width: 900px;
}

/* Support Line */
.support-line {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1.25rem;
  flex-wrap: wrap;
  background: #fff;
  padding: 1.25rem 2rem;
  border-radius: 14px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}

/* Buttons */
.support-btn {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.6rem 1.3rem;
  border-radius: 10px;
  font-weight: 600;
  color: #fff;
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 0.95rem;
}

.support-btn.call {
  background: linear-gradient(135deg, #00C851, #007E33); /* Green */
}

.support-btn.call:hover {
  background: linear-gradient(135deg, #009f42, #006629);
}

.support-btn.email {
  background: linear-gradient(135deg, #0072FF, #00C6FF); /* Blue */
}

.support-btn.email:hover {
  background: linear-gradient(135deg, #005ed4, #00a8e6);
}

/* Support Page Link */
.support-page {
  background: #ff6600;
  color: #fff;
  border-radius: 10px;
  padding: 0.7rem 1.5rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 0.3rem;
  text-decoration: none;
  transition: 0.3s ease;
}

.support-page:hover,
.support-page.active {
  background: #e65c00;
  transform: translateY(-2px);
}

/* Location */
.support-location {
  color: #333;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 0.4rem;
  background: #fef1ec;
  border-radius: 10px;
  padding: 0.6rem 1rem;
}

.text-orange {
  color: #ff6600;
}

/* Social Icons */
.social-icons {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1.5rem;
}

.social-icons a {
  color: #ff6600;
  background: #fff;
  border-radius: 50%;
  width: 42px;
  height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  box-shadow: 0 3px 12px rgba(0,0,0,0.08);
  transition: all 0.3s ease;
}

.social-icons a:hover {
  background: #ff6600;
  color: #fff;
  transform: translateY(-3px);
}

/* Responsive */
@media (max-width: 600px) {
  .support-line {
    flex-direction: column;
    text-align: center;
    gap: 1rem;
  }

  .support-btn, .support-page, .support-location {
    width: 100%;
    justify-content: center;
  }
}
</style>


          
        </div>
      </div>
    </div>
    <!-- side bar end -->

      @if (!Route::is('profile') && !Route::is('support.index') && !Route::is('user.locations')  && !Route::is('user.loan')  && !Route::is('user.referral') && !Route::is('onboarding_page') && !Route::is('terms') && !Route::is('user.orders.show'))

    <!-- header start -->
    <header class="section-t-space">
  <div class="custom-container">
    <div class="header">
      <div class="head-content">
        <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
          <i class="iconsax menu-icon" data-icon="menu-hamburger"></i>
        </button>

        <div class="header-info">
          {{-- <img class="img-fluid profile-pic" 
               src="https://fingo.smartrobtech.co.uk/wp-content/uploads/2025/07/Fingo-Aurelius-LTD-Logo.png" 
               alt="profile" /> --}}
          <div>
            <h4 class="light-text">Hello</h4>
            <h2 class="theme-color">{{ Auth::user()->first_name }}</h2>
          </div>
        </div>
      </div>

     <div class="icon-group d-flex align-items-center gap-3">
    
    <?php $data = user_notifications(); ?>
    <a style="color:black" href="javascript:void(0)"
   class="notification-link position-relative"
   data-bs-toggle="modal"
   data-bs-target="#notificationModal"
   aria-label="Open notifications">
  <i style= "font-size:30px;" class="fa fa-bell"></i>
  <span class="badge bg-danger notification-count" id="notification-count">
    {{ $data['unreadCount'] ?? 0 }}
  </span>
</a>

    <a href="{{ route('cart') }}" class="cart-link position-relative">
        <i class="fa fa-shopping-cart"></i>
        <sup class="badge bg-danger" id="cart-count">0</sup>
    </a>

</div>


<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Notifications</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="notifications-list">
        @forelse($data['notifications'] as $notification)
            @php
                $shortBody = Str::limit($notification->body, 10);
                $isShort = strlen($notification->body) <= 7;
            @endphp

            <div style="text-align:left !important" class="notification-item mb-3 p-3 border rounded"
                 data-id="{{ $notification->id }}"
                 data-full="{{ htmlspecialchars($notification->body, ENT_QUOTES, 'UTF-8') }}">
                <h6 class="mb-1 fw-semibold" style="color:darkorange;">{{ $notification->title }}</h6>

                <p class="mb-2 notification-body">
                    {!! nl2br(e($shortBody)) !!}
                </p>

                @if(!$isShort)
                    <button type="button" class="btn btn-sm btn-dark view-more">View More</button>
                @endif
            </div>
        @empty
            <p class="text-muted text-center">No notifications available.</p>
        @endforelse
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Expanded View Modal -->
<div class="modal fade" id="viewMoreModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content shadow-lg animate__animated animate__zoomIn">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Notification</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="viewMoreContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="cancelViewMore" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Styling -->
<style>
.notification-item {
  transition: all 0.3s ease;
  background: #fff;
}
.notification-item.read {
  opacity: 0.6;
  background: #f8f9fa;
}
.animate__animated {
  animation-duration: 0.3s;
}
</style>

<!-- Current user ID for JS -->
<script>
  window.__CURRENT_USER_ID__ = @json(Auth::id());
</script>

<!-- Core Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const COOKIE_KEY = 'notif_read';
  const currentUserId = String(window.__CURRENT_USER_ID__ || '');
  const countEl = document.getElementById('notification-count');
  const listEl = document.getElementById('notifications-list');
  const viewMoreModalEl = document.getElementById('viewMoreModal');
  const viewMoreModal = new bootstrap.Modal(viewMoreModalEl);
  const viewMoreContent = document.getElementById('viewMoreContent');
  const cancelBtn = document.getElementById('cancelViewMore');
  let currentViewId = null;

  /* ---------- Cookie Helpers ---------- */
  function readCookieObj() {
    const name = COOKIE_KEY + '=';
    const cookies = document.cookie.split(';');
    for (let c of cookies) {
      c = c.trim();
      if (c.startsWith(name)) {
        try {
          return JSON.parse(decodeURIComponent(c.substring(name.length))) || {};
        } catch (e) { return {}; }
      }
    }
    return {};
  }

  function writeCookieObj(obj) {
    const expiry = new Date();
    expiry.setFullYear(expiry.getFullYear() + 1);
    document.cookie = `${COOKIE_KEY}=${encodeURIComponent(JSON.stringify(obj))}; expires=${expiry.toUTCString()}; path=/; samesite=lax`;
  }

  /* ---------- Get user read list ---------- */
  function getUserReadList() {
    const all = readCookieObj();
    const list = all[currentUserId] || [];
    return Array.isArray(list) ? list.map(Number) : [];
  }

  /* ---------- Mark notification as read ---------- */
  function markAsRead(id) {
    if (!currentUserId) return;

    const all = readCookieObj();
    const list = Array.isArray(all[currentUserId]) ? all[currentUserId] : [];
    const num = Number(id);
    if (!list.includes(num)) {
      list.push(num);
      all[currentUserId] = list;
      writeCookieObj(all);
    }

    // Update DOM
    const item = listEl.querySelector(`.notification-item[data-id="${id}"]`);
    if (item) item.classList.add('read');

    // Update count
    updateUnreadCount();
  }

  /* ---------- Update unread count ---------- */
  function updateUnreadCount() {
    const readList = getUserReadList();
    const total = listEl.querySelectorAll('.notification-item').length;
    const unread = Math.max(0, total - readList.length);
    if (countEl) countEl.innerText = unread;
  }

  /* ---------- Apply initial read states ---------- */
  (function initReadState() {
    const readList = getUserReadList();
    listEl.querySelectorAll('.notification-item').forEach(item => {
      const id = Number(item.dataset.id);
      if (readList.includes(id)) item.classList.add('read');
    });
    updateUnreadCount();
  })();

  /* ---------- View More Click ---------- */
  listEl.addEventListener('click', function (e) {
    const btn = e.target.closest('.view-more');
    if (!btn) return;

    const item = btn.closest('.notification-item');
    if (!item) return;

    const full = item.dataset.full || '';
    currentViewId = item.dataset.id;
    viewMoreContent.innerHTML = `<p style="white-space: pre-line;">${full}</p>`;
    viewMoreModal.show();
  });

  /* ---------- When modal shows, mark as read ---------- */
  viewMoreModalEl.addEventListener('shown.bs.modal', function () {
    if (currentViewId) markAsRead(currentViewId);
  });

  /* ---------- Reset after modal hides ---------- */
  viewMoreModalEl.addEventListener('hidden.bs.modal', function () {
    currentViewId = null;
  });

  /* ---------- Cancel Button ---------- */
  cancelBtn.addEventListener('click', function () {
    viewMoreModal.hide();
  });
});
</script>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


<!-- Styles (adjust to your theme) -->
<style>

.notification-link {
    font-size: 20px; /* Adjust to make bell bigger or smaller */
}

.notification-count {
    position: absolute;
    top: -5px;
    right: -3px;
    font-size: 10px;
    border-radius: 50%;
    padding: 3px 6px;
}

.notification-item {
  background: #fff;
  color: black;
  border: none;
  border-left: 5px solid #ff7b00;
}
.notification-item .notification-body { color: black; }
.notification-item .view-more { margin-top: 6px; }
</style>

<!-- Script: expands, marks read in localStorage, updates count -->
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
  const STORAGE_KEY = 'notif_read'; // global key (notification ids array)
  const countEl = document.getElementById('notification-count');
  const listEl = document.getElementById('notifications-list');

  // Helper to get/set read list in localStorage
  function getReadList() {
    try {
      return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
    } catch (e) {
      return [];
    }
  }
  function setReadList(arr) {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(arr));
    } catch (e) {}
  }

  // Apply initial read state (mark items that are in localStorage as read)
  (function applyInitialReadState() {
    const read = getReadList();
    const items = listEl.querySelectorAll('.notification-item');
    items.forEach(item => {
      const id = item.dataset.id;
      if (read.includes(Number(id)) || read.includes(id)) {
        item.classList.add('read');
      }
    });

    // Ensure counter reflects unread based on rendered total and read list.
    // Use server-provided unread as a fallback; prefer client calculation for immediate feedback.
    const totalRendered = items.length;
    const unreadClient = Math.max(0, totalRendered - read.length);
    if (countEl) countEl.innerText = unreadClient;
  })();

  // Event delegation for View More clicks
  listEl.addEventListener('click', function (e) {
    const btn = e.target.closest('.view-more');
    if (!btn) return;

    const parent = btn.closest('.notification-item');
    if (!parent) return;

    const id = parent.dataset.id;
    const full = parent.dataset.full || '';

    // Expand the body in-place (preserve line breaks)
    const bodyEl = parent.querySelector('.notification-body');
    // decode HTML entities already stored earlier (we stored with ENT_QUOTES)
    bodyEl.innerHTML = full.replace(/\n/g, '<br>');

    // Remove the "View More" button (no need to show it twice)
    btn.remove();

    // Mark as read in localStorage
    const readList = getReadList();
    if (!readList.includes(Number(id)) && !readList.includes(id)) {
      readList.push(Number(id));
      setReadList(readList);

      // reduce count visually
      if (countEl) {
        let current = parseInt(countEl.innerText) || 0;
        if (current > 0) {
          countEl.innerText = current - 1;
        }
      }
    }

    // Add read styling
    parent.classList.add('read');
  });

  // Optional: Pause auto scroll or other behavior can go here.

  // When modal closes, nothing else required (state persisted in localStorage)
});
</script> --}}



    </div>
  </div>
</header>
@endif

<style>


.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.head-content {
  display: flex;
  align-items: center;
  gap: 15px;
}

.header-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.profile-pic {
  width: 80px !important;
  height: 60px !important;
  {{-- object-fit: contain; --}}
}

.cart-link {
  position: relative;
  font-size: 20px;
  color: #555;
  text-decoration: none;
}

.cart-link sup {
  position: absolute;
  top: -8px;
  right: -10px;
  font-size: 12px;
}

</style>
    <!-- header end -->

    <!-- search section starts -->
    <section>
      <div class="custom-container">

      @if (Route::is('dashboard') || Route::is('user.packages'))
<form class="theme-form search-head" method="GET" action="{{ route('food.search') }}">
    <div class="form-group">
        <div class="form-input">
            <input 
                type="text" 
                class="form-control search" 
                name="query" 
                id="inputusername" 
                value="{{ request('query') }}" 
                placeholder="Search here..." 
            />
        </div>

        <button type="submit" class="btn filter-btn mt-0">
            <i class="fa fa-search"></i>
        </button>
    </div>
</form>
@endif


       
      </div>
    </section>
    <!-- search section end -->

    @yield('content')
    
    <!-- panel-space start -->
    <section class="panel-space"></section>
    <!-- panel-space end -->

      @if (!Route::is('support.index')  && !Route::is('user.locations')  && !Route::is('user.loan') && !Route::is('user.referral') && !Route::is('onboarding_page') && !Route::is('terms') && !Route::is('user.orders.show'))
    <!-- bottom navbar start -->
   <div class="navbar-menu">
  <ul style="list-style:none; display:flex; gap:30px; padding:0; margin:0;">
    <li>
      <a href="{{ route('dashboard') }}">
        <i class="fa fa-home" 
           style="font-size:28px; color:{{ request()->routeIs('dashboard') ? 'orange' : '#555' }};">
        </i>
        <span class="b-label">Home</span>
      </a>
    </li>

    <li>
      <a href="{{ route('category') }}">
        <i class="fa fa-tag" 
           style="font-size:28px; color:{{ request()->routeIs('category') ? 'orange' : '#555' }};">
        </i>
                <span class="b-label">Category</span>

      </a>
    </li>

    <li>
      <a href="{{ route('user.packages') }}">
        <i class="fa fa-shopping-bag" 
           style="font-size:28px; color:{{ request()->routeIs('user.packages') ? 'orange' : '#555' }};">
        </i>
                        <span class="b-label">Shop</span>

      </a>
    </li>

    <li>
      <a href="{{ route('user.payment') }}">
        <i class="fa fa-exchange" 
           style="font-size:28px; color:{{ request()->routeIs('user.payment') ? 'orange' : '#555' }};">
        </i>
                                <span class="b-label">Payment</span>

      </a>
    </li>

    <li>
      <a href="{{ route('user.orders') }}">
        <i class="fas fa-shopping-cart" 
           style="font-size:28px; color:{{ request()->routeIs('user.orders') ? 'orange' : '#555' }};">
        </i>
                                <span class="b-label">Orders</span>

      </a>
    </li>
  </ul>
</div>
@endif
<style>
.b-label{

  font-size:12px;
}

@media(max-width:375px){
  .b-label{

  font-size:8px !important;
}
}
</style>

    <!-- bottom navbar end -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- swiper js -->
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-swiper.js') }}"></script>

    <!-- range-slider js -->
    <script src="{{ asset('assets/js/range-slider.js') }}"></script>

    <!-- iconsax js -->
    <script src="{{ asset('assets/js/iconsax.js') }}"></script>

    <!-- bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- script js -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function updateCartCount() {
        fetch("/cart/count")
            .then(response => response.json())
            .then(data => {
                console.log("Cart count response:", data); // 🔥 debug
                const cartCountEl = document.getElementById("cart-count");
                if (cartCountEl) {
                    cartCountEl.innerText = data.count ?? 0; // fallback to 0
                }
            })
            .catch(err => {
                const cartCountEl = document.getElementById("cart-count");
                if (cartCountEl) {
                    cartCountEl.innerText = 0; // ✅ show 0 if error
                }
            });
    }

    // Run immediately
    updateCartCount();

    // Refresh every 10 seconds
    setInterval(updateCartCount, 1000);
});
</script>




<!-- Include iziToast CSS & JS if not already included -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

<!-- Modal CSS -->
<style>
    .action_modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .action_modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .action_modal {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 32px;
        max-width: 400px;
        width: 90%;
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.3);
        transform: scale(0.9) translateY(20px);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        text-align: center;
        position: relative;
    }

    .action_modal-overlay.active .action_modal {
        transform: scale(1) translateY(0);
    }

    .action_modal-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .action_modal-icon.success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .action_modal-icon.error {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .action_modal-icon.info {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .action_modal-icon.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .action_modal-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #1f2937;
    }

    .action_modal-message {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .action_modal-btn {
        padding: 12px 28px;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }

    .action_modal-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }
</style>

<!-- Modal HTML -->
<div class="action_modal-overlay" id="clipboardModal" onclick="closeClipboardModal(event)">
    <div class="action_modal" onclick="event.stopPropagation()">
        <div class="action_modal-icon" id="modalIcon">
            <span id="modalIconText"><i class="fa fa-info-circle text-white"></i></span>
        </div>
        <h3 class="action_modal-title" id="modalTitle">Notice</h3>
        <p class="action_modal-message" id="modalMessage">This is a message.</p>
        <button class="action_modal-btn" onclick="closeClipboardModal()">Ok</button>
    </div>
</div>

<!-- Modal JS -->
<script>
    function showSessionModal(type, message) {
        const overlay = document.getElementById('clipboardModal');
        const icon = document.getElementById('modalIcon');
        const iconText = document.getElementById('modalIconText');
        const title = document.getElementById('modalTitle');
        const msg = document.getElementById('modalMessage');

        // Reset classes to allow proper icon color
        icon.className = 'action_modal-icon';

        if (type === 'success') {
            icon.classList.add('success');
            iconText.innerHTML = '<i class="fa fa-check-circle text-white"></i>';
            title.textContent = 'Success!';
        } else if (type === 'info') {
            icon.classList.add('info');
            iconText.innerHTML = '<i class="fa fa-info-circle text-white"></i>';
            title.textContent = 'Info';
        } else if (type === 'warning') {
            icon.classList.add('warning');
            iconText.innerHTML = '<i class="fa fa-exclamation-triangle text-white"></i>';
            title.textContent = 'Warning';
        } else if (type === 'error') {
            icon.classList.add('error');
            iconText.innerHTML = '<i class="fa fa-times-circle text-white"></i>';
            title.textContent = 'Error';
        } else {
            icon.classList.add('info');
            iconText.innerHTML = '<i class="fa fa-info-circle text-white"></i>';
            title.textContent = 'Notice';
        }

        msg.textContent = message;
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeClipboardModal(event) {
        if (event && event.target !== event.currentTarget) return;

        const overlay = document.getElementById('clipboardModal');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close modal on Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeClipboardModal();
        }
    });

    @if(Session::has('message'))
    // Get Laravel flash message type and message
    const type = "{{ Session::get('alert-type', 'info') }}";
    const message = "{{ Session::get('message') }}";

    // Show modal on page load
    showSessionModal(type, message);

    // Clear session keys so it won't show again
    {{ Session::forget('message') }}
    {{ Session::forget('alert-type') }}
    @endif
</script>

    
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
{{-- var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/64a3f86294cf5d49dc617131/1j6d8cfcp';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})(); --}}
</script>
<!--End of Tawk.to Script-->
  </body>

<!-- Mirrored from themes.pixelstrap.com/fuzzy/landing.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Sep 2025 07:35:23 GMT -->
</html>
