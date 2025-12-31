<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from zoyothemes.com/hando/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 19 Sep 2025 12:01:10 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

        <meta charset="utf-8" />
        <title>Aurelius - Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."/>
        <meta name="author" content="Zoyothemes"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

        <!-- App css -->
<link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

<!-- Icons -->
<link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Head JS -->
<script src="{{ asset('admin/assets/js/head.js') }}"></script>

<style>
#sidebar-menu .menuitem-active .active, #sidebar-menu .menuitem-active>a{
        color: white !important;
        background: darkorange !important;
        margin:10px;

}



</style>

<style>
.bg-warning{
  background-color:darkorange !important;
}



</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal').forEach(modal => {
        modal.setAttribute('data-bs-backdrop', 'static');
        modal.setAttribute('data-bs-keyboard', 'false');
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

    </head>

    <!-- body start -->
    <body data-menu-color="light" data-sidebar="default">

        <!-- Begin page -->
        <div id="app-layout">

            <!-- Topbar Start -->
            <div class="topbar-custom">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                            <li>
                                <button class="button-toggle-menu nav-link">
                                    <i data-feather="menu" class="noti-icon"></i>
                                </button>
                            </li>
                            <li class="d-none d-lg-block">
@php
    $hour = now()->format('H');
    if ($hour < 12) {
        $greeting = "Good Morning";
    } elseif ($hour < 18) {
        $greeting = "Good Afternoon";
    } else {
        $greeting = "Good Evening";
    }
@endphp

<h5 class="mb-0">{{ $greeting }}, {{ Auth::user()->first_name }}</h5>
                            </li>
                        </ul>

                        <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                            {{-- <li class="d-none d-lg-block">
                                <form class="app-search d-none d-md-block me-auto">
                                    <div class="position-relative topbar-search">
                                        <input type="text" class="form-control ps-4" placeholder="Search..." />
                                        <i class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                                    </div>
                                </form>
                            </li> --}}

                            <!-- Button Trigger Customizer Offcanvas -->
                            {{-- <li class="d-none d-sm-flex">
                                <button type="button" class="btn nav-link" data-toggle="fullscreen">
                                    <i data-feather="maximize" class="align-middle fullscreen noti-icon"></i>
                                </button>
                            </li> --}}

                            <!-- Light/Dark Mode Button Themes -->
                            {{-- <li class="d-none d-sm-flex">
                                <button type="button" class="btn nav-link" id="light-dark-mode">
                                    <i data-feather="moon" class="align-middle dark-mode"></i>
                                    <i data-feather="sun" class="align-middle light-mode"></i>
                                </button>
                            </li> --}}

                            {{-- <li class="dropdown notification-list topbar-dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i data-feather="bell" class="noti-icon"></i>
                                    <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0">
                                            <span class="float-end"><a href="#" class="text-dark"><small>Clear All</small></a></span>Notification
                                        </h5>
                                    </div>

                                    <div class="noti-scroll" data-simplebar>
                                        <!-- item-->
                                        <a href="javascript:void(0);"
                                            class="dropdown-item notify-item text-muted link-primary active">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-12.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="notify-details">Carl Steadham</p>
                                                <small class="text-muted">5 min ago</small>
                                            </div>
                                            <p class="mb-0 user-msg">
                                                <small class="fs-14">Completed <span class="text-reset">Improve workflow in Figma</span></small>
                                            </p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-2.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="notify-content">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="notify-details">Olivia McGuire</p>
                                                    <small class="text-muted">1 min ago</small>
                                                </div>

                                                <div class="d-flex mt-2 align-items-center">
                                                    <div class="notify-sub-icon">
                                                        <i class="mdi mdi-download-box text-dark"></i>
                                                    </div>

                                                    <div>
                                                        <p class="notify-details mb-0">dark-themes.zip</p>
                                                        <small class="text-muted">2.4 MB</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-3.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="notify-content">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="notify-details">Travis Williams</p>
                                                    <small class="text-muted">7 min ago</small>
                                                </div>
                                                <p class="noti-mentioned p-2 rounded-2 mb-0 mt-2">
                                                    <span class="text-primary">@Patryk</span> Please make sure that you're....
                                                </p>
                                            </div>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-8.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="notify-details">Violette Lasky</p>
                                                <small class="text-muted">5 min ago</small>
                                            </div>
                                            <p class="mb-0 user-msg">
                                                <small class="fs-14">Completed <span class="text-reset">Create new components</span></small>
                                            </p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-5.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="notify-details">Ralph Edwards</p>
                                                <small class="text-muted">5 min ago</small>
                                            </div>
                                            <p class="mb-0 user-msg">
                                                <small class="fs-14">Completed<span class="text-reset">Improve workflow in React</span></small>
                                            </p>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item text-muted link-primary">
                                            <div class="notify-icon">
                                                <img src="assets/images/users/user-6.jpg" class="img-fluid rounded-circle" alt="" />
                                            </div>
                                            <div class="notify-content">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="notify-details">Jocab jones</p>
                                                    <small class="text-muted">7 min ago</small>
                                                </div>
                                                <p class="noti-mentioned p-2 rounded-2 mb-0 mt-2">
                                                    <span class="text-reset">@Patryk</span> Please make sure that you're....
                                                </p>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">View all
                                        <i class="fe-arrow-right"></i>
                                    </a>
                                </div>
                            </li> --}}

                            <!-- User Dropdown -->
                            <li class="dropdown notification-list topbar-dropdown">
                                {{-- <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/users/user-13.jpg" alt="user-image" class="rounded-circle" />
                                    <span class="pro-user-name ms-1">Alex <i class="mdi mdi-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end profile-dropdown"> --}}

                                    <!-- item-->
                                    {{-- <a class='dropdown-item notify-item' href='pages-profile.html'>
                                        <i class="mdi mdi-account-circle-outline fs-16 align-middle"></i>
                                        <span>My Account</span>
                                    </a> --}}

                                    <!-- item-->
                                    {{-- <a class='dropdown-item notify-item' href='auth-lock-screen.html'>
                                        <i class="mdi mdi-lock-outline fs-16 align-middle"></i>
                                        <span>Lock Screen</span>
                                    </a> --}}

                                    <div class="dropdown-divider"></div>

                                    <!-- item-->
                                    <li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
    <a style="color:red;" class="sidenav-item-link" href="#"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="mdi mdi-logout"></i>
        <span class="nav-text">Logout</span>
    </a>
</li>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end Topbar -->

            <!-- Left Sidebar Start -->
            <div class="app-sidebar-menu">
                <div class="h-100" data-simplebar>

                    <!--- Sidemenu -->
                    <div style="height:100px !important" id="sidebar-menu">

                        <div class="logo-box">
                            <a class='logo logo-light' href="{{ route('admin.dashboard') }}">
                                <span class="logo-sm">
                                    <img style="height 100px !important" src="{{ asset('logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img style="height 100px !important" src="{{ asset('logo.png') }}" alt="" height="100">
                                </span>
                            </a>
                            <a class='logo logo-dark' href="{{ route('admin.dashboard') }}">
                                <span class="logo-sm">
                                    <img style="height 100px !important" src="{{ asset('logo.png') }}" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img style="height 200px !important; width:40px;" src="{{ asset('logo.png') }}" alt="" height="24">
                                </span>
                            </a>
                        </div>

                        <ul id="side-menu">

                            <!-- Dashboard -->
    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline"></i>
            <span> Dashboard </span>
        </a>
    </li>

        @if (Auth::user()->user_role === 'admin')

    <!-- Manage Foods (Dropdown) -->
    <li>
        <a href="#sidebarFoods" data-bs-toggle="collapse" aria-expanded="false">
            <i class="mdi mdi-basket-outline"></i>
            <span> Manage Foods </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse {{ request()->routeIs(['category.view','admin.product.add','foods.all']) ? 'show' : '' }}" id="sidebarFoods">
            <ul class="nav-second-level">
                <li class="{{ request()->routeIs('category.view') ? 'active' : '' }}">
                    <a href="{{ route('category.view') }}">Manage Category</a>
                </li>
                <li class="{{ request()->routeIs('admin.product.add') ? 'active' : '' }}">
                    <a href="{{ route('admin.product.add') }}">Add Food</a>
                </li>
                <li class="{{ request()->routeIs('foods.all') ? 'active' : '' }}">
                    <a href="{{ route('foods.all') }}">All Foods</a>
                </li>
            </ul>
        </div>
    </li>
@endif


            @if (has_permission('manage_orders') || Auth::user()->user_role === 'admin')

 <li>
        <a href="#sidebarFoodss" data-bs-toggle="collapse" aria-expanded="false">
            <i class="fas fa-box-open"></i>
            <span> Manage Orders </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse {{ request()->routeIs(['admin.orders','pending.admin.orders','approved.admin.orders','preparing.admin.orders','dispatched.admin.orders', 'delivered.admin.orders','denied.admin.orders','abandoned.admin.orders']) ? 'show' : '' }}" id="sidebarFoodss">
            <ul class="nav-second-level">
                <li class="{{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders') }}">All Orders</a>
                </li>
                <li class="{{ request()->routeIs('pending.admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('pending.admin.orders') }}">Under Review Orders</a>
                </li>

                <li class="{{ request()->routeIs('approved.admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('approved.admin.orders') }}">Approved Orders</a>
                </li>

                <li class="{{ request()->routeIs('preparing.admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('preparing.admin.orders') }}">Preparing Orders</a>
                </li>

                <li class="{{ request()->routeIs('dispatched.admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('dispatched.admin.orders') }}">Dispatched Orders</a>
                </li>

                <li class="{{ request()->routeIs('delivered.admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('delivered.admin.orders') }}">Delivered Orders</a>
                </li>

              <li class="{{ request()->routeIs('denied.admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('denied.admin.orders') }}">Denied Orders</a>
                </li>
              <li class="{{ request()->routeIs('abandoned.admin.orders') ? 'active' : '' }}">
                    <a href="{{ route('abandoned.admin.orders') }}">Abandoned Orders</a>
                </li>


            </ul>
        </div>
    </li>


    @endif



            @if (has_permission('manage_payment') || Auth::user()->user_role === 'admin')

    <li>
        <a href="#sidebarFoodsq" data-bs-toggle="collapse" aria-expanded="false">
            <i class="fas fa-wallet"></i>
            <span> Manage Payments </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse {{ request()->routeIs(['admin.payment','outstanding.history','onboarding.history', 'onboarding.history', 'processing.history', 'wallet.history']) ? 'show' : '' }}" id="sidebarFoodsq">
            <ul class="nav-second-level">
                <li class="{{ request()->routeIs('admin.payment') ? 'active' : '' }}">
                    <a href="{{ route('admin.payment') }}">All Payments</a>
                </li>

                <li class="{{ request()->routeIs('outstanding.history') ? 'active' : '' }}">
                    <a href="{{ route('outstanding.history') }}">Outstanding Repayment</a>
                </li>
                <li class="{{ request()->routeIs('onboarding.history') ? 'active' : '' }}">
                    <a href="{{ route('onboarding.history') }}">Onboarding</a>
                </li>
                <li class="{{ request()->routeIs('processing.history') ? 'active' : '' }}">
                    <a href="{{ route('processing.history') }}">Processing Fee</a>
                </li>
                <li class="{{ request()->routeIs('wallet.history') ? 'active' : '' }}">
                    <a href="{{ route('wallet.history') }}">Wallet Purchase</a>
                </li>
                <li class="{{ request()->routeIs('service_charge') ? 'active' : '' }}">
                    <a href="{{ route('service_charge') }}">Service Charge</a>
                </li>
                <li class="{{ request()->routeIs('wallet.adjustment.history') ? 'active' : '' }}">
                    <a href="{{ route('wallet.adjustment.history') }}">Wallet Adjustment History</a>
                </li>
            </ul>
        </div>
    </li>

    @endif




                @if (Auth::user()->user_role === 'admin')

    <!-- Manage Levels -->
    <li class="{{ request()->routeIs('manage.account.level') ? 'active' : '' }}">
        <a href="{{ route('manage.account.level') }}">
            <i class="fas fa-layer-group"></i>
            <span> Manage Levels </span>
        </a>
    </li>

    @endif

    @if (has_permission('sign_up_users'))
        <li class="{{ request()->routeIs('admin.users.pending_kyc') ? 'active' : '' }}">
            <a href="{{ route('admin.users.pending_kyc') }}">
                <i class="fas fa-id-card"></i>
                <span> Sign up users</span>
                <span class="badge bg-warning ms-2">{{ \App\Models\User::where(function($q) { $q->where('has_done_kyc', '!=', 'yes')->orWhereNull('has_done_kyc'); })->count() }}</span>
            </a>
        </li>
    @endif

    @if (has_permission('abandoned_orders'))
        <li class="{{ request()->routeIs('abandoned.admin.orders') ? 'active' : '' }}">
            <a href="{{ route('abandoned.admin.orders') }}">
                <i class="fas fa-box-open"></i>Abandoned Orders
            </a>
        </li>
    @endif

                @if (Auth::user()->user_role === 'admin')

    <!-- Manage Users (Dropdown) -->
    <li>
        <a href="#sidebarUsers" data-bs-toggle="collapse" aria-expanded="false">
            <i class="fas fa-users-cog"></i>
            <span> Manage Users </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse {{ request()->routeIs(['manage.user','admin.users.employment','admin.users.students','admin.users.employed','admin.users.self_employed','admin.users.unemployed','admin.users.levels','admin.users.levels.low','admin.users.levels.medium','admin.users.levels.high','admin.users.levels.market','admin.users.pending_kyc','admin.users.active']) ? 'show' : '' }}" id="sidebarUsers">
            <ul class="nav-second-level">
                <li class="{{ request()->routeIs('manage.user') ? 'active' : '' }}">
                    <a href="{{ route('manage.user') }}">All Users</a>
                </li>
                <li class="{{ request()->routeIs('admin.users.active') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.active') }}">
                        <i class="fas fa-user-check"></i>
                        <span> Active Users</span>
                        <span class="badge bg-success ms-2">{{ \App\Models\User::where('has_done_kyc', 'yes')->where('has_paid_onboarding', 'yes')->count() }}</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.users.pending_kyc') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.pending_kyc') }}">
                        <i class="fas fa-id-card"></i>
                        <span> Sign up users</span>
                        <span class="badge bg-warning ms-2">{{ \App\Models\User::where(function($q) { $q->where('has_done_kyc', '!=', 'yes')->orWhereNull('has_done_kyc'); })->count() }}</span>
                    </a>
                </li>
                <li>
                    <a href="#sidebarUsersEmployment" data-bs-toggle="collapse" aria-expanded="false">
                        <span>By Employment Status</span>
                        <span class="menu-arrow float-end"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs(['admin.users.employment','admin.users.students','admin.users.employed','admin.users.self_employed','admin.users.unemployed']) ? 'show' : '' }}" id="sidebarUsersEmployment">
                        <ul class="nav-third-level">
                            <li class="{{ request()->routeIs('admin.users.employment') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.employment') }}">All Employment Types</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users.students') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.students') }}"><i class="fas fa-graduation-cap"></i> Students</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users.employed') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.employed') }}"><i class="fas fa-briefcase"></i> Employed</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users.self_employed') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.self_employed') }}"><i class="fas fa-user-tie"></i> Self-Employed</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users.unemployed') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.unemployed') }}"><i class="fas fa-user"></i> Unemployed</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#sidebarUsersLevel" data-bs-toggle="collapse" aria-expanded="false">
                        <span>By Level</span>
                        <span class="menu-arrow float-end"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs(['admin.users.levels','admin.users.levels.low','admin.users.levels.medium','admin.users.levels.high','admin.users.levels.market']) ? 'show' : '' }}" id="sidebarUsersLevel">
                        <ul class="nav-third-level">
                            <li class="{{ request()->routeIs('admin.users.levels') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.levels') }}">All Levels</a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users.levels.low') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.levels.low') }}"><span class="badge bg-info">Low</span></a>
                            </li>
                            <li class="{{ request()->routeIs('admin.users.levels.medium') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.levels.medium') }}"><span class="badge bg-warning">Medium</span></a>
                            </li>
                            {{-- <li class="{{ request()->routeIs('admin.users.levels.high') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.levels.high') }}"><span class="badge bg-success">High</span></a>
                            </li> --}}
                            <li class="{{ request()->routeIs('admin.users.levels.market') ? 'active' : '' }}">
                                <a href="{{ route('admin.users.levels.market') }}"><span class="badge bg-danger">Market Woman</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </li>
    @endif
                @if (Auth::user()->user_role === 'admin')

    <li class="{{ request()->routeIs('admin_manager.view') ? 'active' : '' }}">
        <a href="{{ route('admin_manager.view') }}">
            <i class="fas fa-users-cog"></i>
            <span> Manage Managers </span>
        </a>
    </li>

    @endif

            @if (has_permission('manage_outstanding') || Auth::user()->user_role === 'admin')

    <!-- Manage Users -->
    <li class="{{ request()->routeIs('manage.loan') ? 'active' : '' }}">
        <a href="{{ route('manage.loan') }}">
<i class="fas fa-money-bill-wave"></i>
            <span> Manage Outstanding </span>
        </a>
    </li>

    @endif

        @if (has_permission('manage_platform') || Auth::user()->user_role === 'admin')

    <li class="{{ request()->routeIs('address.index') ? 'active' : '' }}">
        <a href="{{ route('address.index') }}">
<i class="fas fa-map"></i>
            <span> Manage Locations </span>
        </a>
    </li>
    @endif

        @if (Auth::user()->user_role === 'admin')

    <!-- Manage Foods (Dropdown) -->
    <li>
        <a href="#sidebarFoodws" data-bs-toggle="collapse" aria-expanded="false">
<i class="mdi mdi-account-multiple-outline"></i>
            <span> Manage Referrals </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse {{ request()->routeIs(['referral.settings', 'admin.history', 'admin.referral.leaderboard']) ? 'show' : '' }}" id="sidebarFoodws">
            <ul class="nav-second-level">
                <li class="{{ request()->routeIs('referral.settings') ? 'active' : '' }}">
                    <a href="{{ route('referral.settings') }}">Referral Settings</a>
                </li>
                <li class="{{ request()->routeIs('admin.history') ? 'active' : '' }}">
                    <a href="{{ route('admin.history') }}">Earning History</a>
                </li>

                <li class="{{ request()->routeIs('admin.referral.leaderboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.referral.leaderboard') }}">LeaderBoards</a>
                </li>

            </ul>
        </div>
    </li>

@endif
        @if (has_permission('manage_operational_state') || Auth::user()->user_role === 'admin')

    <li class="{{ request()->routeIs('operational.states') ? 'active' : '' }}">
        <a href="{{ route('operational.states') }}">
<i class="fas fa-map"></i>
            <span> Manage Operational States </span>
        </a>
    </li>
    @endif
    @if (has_permission('manage_notification') || Auth::user()->user_role === 'admin')
<li class="{{ request()->routeIs('notification.index') ? 'active' : '' }}">
    <a href="{{ route('notification.index') }}">
        <i class="fas fa-bell"></i>
        <span> Manage Notification </span>
    </a>
</li>
@endif

        @if (has_permission('manage_platform') || Auth::user()->user_role === 'admin')

    <li class="{{ request()->routeIs('platform') ? 'active' : '' }}">
        <a href="{{ route('platform') }}">
<i class="fas fa-cog"></i>        <!-- simple gear -->
            <span> Platform Settings </span>
        </a>
    </li>

    @endif

            @if (has_permission('manage_platform') || Auth::user()->user_role === 'admin')

    <li class="{{ request()->routeIs('platform.shop') ? 'active' : '' }}">
        <a href="{{ route('platform.shop') }}">
<i class="fas fa-cog"></i>        <!-- simple gear -->
            <span> Shop Slider Settings </span>
        </a>
    </li>

    @endif

     @if (Auth::user()->user_role === 'admin')

    <li class="{{ request()->routeIs('audit.log') ? 'active' : '' }}">
        <a href="{{ route('audit.log') }}">
<i class="fas fa-history"></i>            <span>Audit Log </span>
        </a>
    </li>

    @endif

    <li class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
        <a href="{{ route('admin.profile') }}">
<i class="fas fa-user"></i>            <span>Profile </span>
        </a>
    </li>



    <!-- Logout -->
    <li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout"></i>
            <span> Logout </span>
        </a>
    </li>
                        </ul>

                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                            <div class="flex-grow-1">
                                {{-- <h4 class="fs-18 fw-semibold m-0">Dashboard</h4> --}}
                            </div>
                        </div>

					@yield('content')

                    </div> <!-- container-fluid -->
                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col fs-13 text-muted text-center">
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Vendor -->
        <script src="{{ asset('admin/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/feather-icons/feather.min.js') }}"></script>

<!-- Apexcharts JS -->
<script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Widgets Init Js -->
<script src="{{ asset('admin/assets/js/pages/crm-dashboard.init.js') }}"></script>

<!-- App js-->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>



@if(session('notification'))
    <?php $notif = session('notification'); ?>

    <!-- Hidden trigger -->
    <button type="button" class="btn btn-primary d-none" id="notifTrigger" data-bs-toggle="modal" data-bs-target="#notifModal"></button>

    <!-- Modern Notification Modal -->
    <div class="modal fade" id="notifModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <!-- Header with gradient background -->
                <div class="modal-header
                    @if($notif['type']=='success') bg-gradient-success
                    @elseif($notif['type']=='error') bg-gradient-danger
                    @else bg-gradient-info @endif
                    text-white border-0">
                    <h5 class="modal-title w-100 text-center">{{ $notif['title'] }}</h5>
                </div>

                <!-- Body -->
                <div class="modal-body text-center p-4" style="font-size: 1.1rem; color: #333;">
                    <p class="mb-0">{{ $notif['message'] }}</p>
                </div>

                <!-- Footer -->
                <div class="modal-footer justify-content-center border-0 pb-4">
                    <button class="btn btn-outline-dark px-4 rounded-pill" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Extra Styles -->
    <style>
        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745, #218838);
        }
        .bg-gradient-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }
        #notifModal .modal-content {
            animation: pop-in 0.3s ease-out;
        }
        @keyframes pop-in {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>

    <!-- Auto-show script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('notifTrigger').click();
        });
    </script>
@endif



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


<script>
    $(document).ready(function () {
        var table = $('#my-table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: true // optional but recommended for responsive tables
        });

        // Adjust columns and redraw table after initialization
        table.columns.adjust().draw();

        // Hook for Level filter buttons present on pages with #my-table
        const levelHeaderIndex = $('#my-table thead th').filter(function(){
            return $(this).text().trim().toLowerCase() === 'level';
        }).index();

        if (levelHeaderIndex >= 0) {
            $(document).on('click', '[data-level-filter]', function(){
                const val = $(this).data('level-filter');
                if (val) {
                    table.column(levelHeaderIndex).search(val, true, false).draw();
                } else {
                    table.column(levelHeaderIndex).search('').draw();
                }
            });
        }
    });
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

{{-- <script> var editor = new FroalaEditor('#myTextarea'); </script> --}}


<script>

document.querySelectorAll('textarea[id^="myTextareaBox"]').forEach((textarea) => {
    ClassicEditor.create(textarea).catch(error => console.error(error));
});

    ClassicEditor
        .create(document.querySelector('#myTextarea'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#myTextarea2'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#myTextarea3'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#myTextarea4'))
        .catch(error => {
            console.error(error);
        });
</script>

<style>
    /* Custom styles to enlarge the editor */
    .ck-editor__editable_inline {
        min-height: 200px;
        width: 100%;
    }
</style>

    </body>


<!-- Mirrored from zoyothemes.com/hando/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 19 Sep 2025 12:03:18 GMT -->
</html>
