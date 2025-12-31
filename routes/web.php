<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OperationalStateController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\UserDashboardController;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use App\Models\PlatformSetting;
use App\Models\ReferralSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


















Route::get('/', function () {
    return view('auth_new.login');
});

Route::get('/dashboard', function () {
    // $recent_orders = Order::where('user_id', Auth::id())->paginate(5);
    $foods = Food::paginate(4);
    $refferal_settings = ReferralSetting::first();
    $settings = PlatformSetting::first();

    return view('user_new.dashboard', compact('foods', 'settings', 'refferal_settings'));
})->middleware(['auth', 'verified', 'web'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/check/login', [AuthController::class, 'check_login'])->name('check_login');


Route::get('/locations/states', [RegisteredUserController::class, 'getStates']);
Route::get('/locations/lgas/{state}', [RegisteredUserController::class, 'getLgas']);
Route::get('/verify-otp', [AuthController::class, 'showVerifyForm'])->name('otp.verify');
Route::post('/verify-otp', [AuthController::class, 'verify'])->name('otp.verify.submit');
Route::post('/resend-otp', [AuthController::class, 'resend'])->name('otp.resend');


Route::middleware(['auth', 'onboard_kyc'])->group(function () {
    Route::get('/terms', [UserDashboardController::class, 'terms'])->name('terms');
});

// ✅ User Dashboard (requires KYC onboarding)
Route::middleware(['auth'])->group(function () {

    // routes/web.php or routes/api.php
    Route::get('/cart/count', function () {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        $items = $cart->items ?? [];

        $count = count($items);
        return response()->json(['count' => $count]);
    });
    // Dashboard


    Route::get('/referral', [ReferralController::class, 'referralPage'])->name('user.referral');

    Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::get('/locations', [AddressController::class, 'user_location'])->name('user.locations');
    Route::post('/support/store', [SupportTicketController::class, 'store'])->name('support.store');
    Route::post('/support/update/{id}', [SupportTicketController::class, 'update'])->name('support.update');
    Route::post('/support/delete/{id}', [SupportTicketController::class, 'destroy'])->name('support.delete');

    // Profile
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('user.profile');

    // Credit & Eligibility
    Route::get('/credit', [UserDashboardController::class, 'credit'])->name('user.credit');

    // Apply for Foodstuff Plan
    Route::get('/apply-plan', [UserDashboardController::class, 'apply'])->name('user.apply.plan');

    // Foodstuff Packages
    Route::get('/shop', [UserDashboardController::class, 'browse'])->name('user.packages');
    Route::get('/shop/detail/{name}', [UserDashboardController::class, 'shop_detail'])->name('shop.detail');
    Route::get('/categories', [UserDashboardController::class, 'category'])->name('category');
    Route::get('/food/category/{name}', [UserDashboardController::class, 'food_category'])->name('food.category');
    Route::get('/my-packages', [UserDashboardController::class, 'myPackages'])->name('user.my.packages');

    Route::get('/search-food', [UserDashboardController::class, 'search_food'])->name('food.search');

    // Repayment
    Route::get('/repayments/schedule', [UserDashboardController::class, 'schedule'])->name('user.repayments.schedule');
    Route::get('/repayments/history', [UserDashboardController::class, 'history'])->name('user.repayments.history');

    // Delivery Status
    Route::get('/delivery-status', [UserDashboardController::class, 'deliveryStatus'])->name('user.delivery.status');

    // Notifications
    Route::get('/notifications', [UserDashboardController::class, 'notifications'])->name('user.notifications');

    // Support
    Route::get('/cart', [UserDashboardController::class, 'my_cart'])->name('cart');

    // Logout
    Route::get('/user/payment', [PackageController::class, 'payment_user'])->name('user.payment');
    Route::get('/select-package', [PackageController::class, 'showForm'])->name('package.form');


    Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders/processing/payment', [PackageController::class, 'pay_processing_fee'])->name('order.processing');
    Route::get('/generate/virtual/account/', [PackageController::class, 'generate_virtual_account'])->name('generate_virtual_account');

    // Assuming you have a food market route
    //Route::get('/food-market', 'YourFoodMarketController@index')->name('food-market');
    Route::get('/orders', [OrderController::class, 'index'])->name('user.orders');
    Route::get('/loan/history', [UserDashboardController::class, 'user_loan_history'])->name('user.loan');

    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('user.orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('user.orders.cancel');

    // Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart', [CartController::class, 'destroy']);

    Route::post('/cart/update', [CartController::class, 'update_cart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove_from_cart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear_cart'])->name('cart.clear');
    Route::post('/pay/processing-fee', [PackageController::class, 'pay_processing_fee_onspot'])
        ->name('pay.processing.fee.onspot');

    Route::get('/profile', [UserDashboardController::class, 'user_profile'])->name('profile');

    Route::post('/profile/add-address', [UserDashboardController::class, 'addAddress'])->name('profile.addAddress');
    Route::post('/profile/delete-address/{index}', [UserDashboardController::class, 'deleteAddress'])->name('profile.deleteAddress');
    Route::post('/profile/change-password', [UserDashboardController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/profile/delete-account', [UserDashboardController::class, 'deleteAccount'])->name('profile.deleteAccount');

    Route::delete('/orders/delete/{order}', [OrderController::class, 'delete_user_order'])
        ->name('user.orders.delete')
        ->middleware('auth');

    Route::post('/profile/send-otp', [UserDashboardController::class, 'sendOtp'])->name('profile.sendOtp');
    Route::post('/profile/verify-otp', [UserDashboardController::class, 'verifyOtp'])->name('profile.verifyOtp');
    Route::post('/profile/update-alt-phone', [UserDashboardController::class, 'updateAltPhone'])->name('profile.updateAltPhone');
    Route::post('/profile/upload-image', [UserDashboardController::class, 'uploadImage'])->name('profile.uploadImage');

    Route::post('/admin/users/{id}/update-alt-contact', [UserDashboardController::class, 'updateAltContact'])
        ->name('admin.users.updateAltContact');
});


Route::get('/pay/onboarding', [PackageController::class, 'startPayment'])->name('pay.onboarding');


Route::get('/payment/callback', [PackageController::class, 'paymentCallback'])->name('package.callback');

// Route::get('/kyc/webhook', [PackageController::class, 'webhook'])->name('kyc.webhook');
Route::post('/kyc/webhook', [PackageController::class, 'webhook'])->name('kyc.webhook');

Route::post('/kyc/process/{level}', [PackageController::class, 'launch'])->name('kyc.process');
Route::match(['get', 'post'], '/kyc/complete', [PackageController::class, 'complete'])->name('kyc.complete');

Route::match(['get', 'post'], '/dojah/webhook', [PackageController::class, 'handleWebhook']);


Route::post('/payment/webhook', [PackageController::class, 'webhook'])->name('package.webhook');
Route::get('/my/onboarding', [PackageController::class, 'onboarding_page'])
    ->middleware(['auth', 'verified', 'web'])->name('onboarding_page');

Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add_cart'])->name('cart.add');
Route::post('/repayment/pay/{id}', [PackageController::class, 'pay_repayment'])->name('repayment.pay');
Route::post('/total/repayment', [PackageController::class, 'total_repayment'])->name('total.repayment');




Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('addresses', [AddressController::class, 'index'])->name('address.index');
    Route::post('addresses', [AddressController::class, 'store'])->name('address.add');
    Route::post('addresses/update/{id}', [AddressController::class, 'update'])->name('address.update');
    Route::post('addresses/delete/{id}', [AddressController::class, 'destroy'])->name('address.delete');

    Route::get('/admin/operational-states', [OperationalStateController::class, 'index'])->name('operational.states');
    Route::post('/admin/operational-states', [OperationalStateController::class, 'store'])->name('operational.states.store');
    Route::post('/admin/operational-states/{id}', [OperationalStateController::class, 'update'])->name('operational.states.update');
    Route::post('/admin/operational-states/delete/{id}', [OperationalStateController::class, 'destroy'])->name('operational.states.delete');
});

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');
    Route::post('/notifications/add', [NotificationController::class, 'store'])->name('notification.add');
    Route::post('/notifications/update/{id}', [NotificationController::class, 'update'])->name('notification.update');
    Route::post('/notifications/delete/{id}', [NotificationController::class, 'destroy'])->name('notification.delete');
});

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/foods/create', [AdminController::class, 'product_view'])->name('admin.product.add');
    Route::post('/foods/store', [AdminController::class, 'product_store'])->name('foods.store');
    Route::post('/foods/update/{id}', [AdminController::class, 'product_update'])->name('foods.update');
    Route::get('/foods/edit/{id}', [AdminController::class, 'product_edit'])->name('foods.edit');
    Route::delete('/foods/delete/{id}', [AdminController::class, 'product_delete'])->name('foods.destroy');
    Route::get('/foods/all', [AdminController::class, 'product_all'])->name('foods.all');

    Route::get('/orders', [AdminController::class, 'admin_orders'])->name('admin.orders');
    Route::get('/pending/orders', [AdminController::class, 'pending_admin_orders'])->name('pending.admin.orders');
    Route::get('/approved/orders', [AdminController::class, 'approved_admin_orders'])->name('approved.admin.orders');
    Route::get('/preparing/orders', [AdminController::class, 'preparing_admin_orders'])->name('preparing.admin.orders');
    Route::get('/dispatched/orders', [AdminController::class, 'dispatched_admin_orders'])->name('dispatched.admin.orders');
    Route::get('/delivered/orders', [AdminController::class, 'delivered_admin_orders'])->name('delivered.admin.orders');
    Route::get('/denied/orders', [AdminController::class, 'denied_admin_orders'])->name('denied.admin.orders');
    Route::get('/abandoned/orders', [AdminController::class, 'abandoned_admin_orders'])->name('abandoned.admin.orders');

    Route::post('/orders/update-status', [AdminController::class, 'updateStatus'])
        ->name('admin.update.order');

        Route::post('/admin/users/update-wallet/{id}', [AdminController::class, 'manage_wallet'])
     ->name('manage.wallet');

    // Route::get('/orders/{order}', [AdminController::class, 'admin_order_show'])->name('admin.order.show');

    Route::get('/payment', [AdminController::class, 'payment_admin'])->name('admin.payment');
    Route::get('/onboarding/payment', [AdminController::class, 'payment_admin_onboarding'])->name('onboarding.history');
    Route::get('/wallet/payment', [AdminController::class, 'payment_admin_wallet'])->name('wallet.history');
    Route::get('/service/charge/payment', [AdminController::class, 'payment_admin_service_charge'])->name('service_charge');
    Route::get('/processing/payment', [AdminController::class, 'payment_admin_processing'])->name('processing.history');
    Route::get('/outstanding/payment', [AdminController::class, 'payment_admin_outstanding'])->name('outstanding.history');
    Route::get('/wallet/adjustment/payment', [AdminController::class, 'payment_admin_wallet_adjustment'])->name('wallet.adjustment.history');
    Route::get('/state/orders/preparing/{name}', [AdminController::class, 'state_orders_preparing'])->name('state.orders.preparing');
    Route::get('/state/orders/ready/{name}', [AdminController::class, 'state_orders_ready'])->name('state.orders.ready');

    Route::get('/support', [SupportTicketController::class, 'admin_support'])->name('admin.support');
    Route::post('/support/update-status/{id}', [SupportTicketController::class, 'updateStatus'])->name('support.updateStatus');


    Route::get('/kyc-levels', [AdminController::class, 'kyc_level'])->name('manage.account.level');
    Route::get('/manage/user/', [AdminController::class, 'manage_user'])->name('manage.user');

    // ✅ Users by Employment Status - Channels
    Route::get('/users/employment/all', [AdminController::class, 'users_by_employment'])->name('admin.users.employment');
    Route::get('/users/employment/students', [AdminController::class, 'users_students'])->name('admin.users.students');
    Route::get('/users/employment/employed', [AdminController::class, 'users_employed'])->name('admin.users.employed');
    Route::get('/users/employment/self-employed', [AdminController::class, 'users_self_employed'])->name('admin.users.self_employed');
    Route::get('/users/employment/unemployed', [AdminController::class, 'users_unemployed'])->name('admin.users.unemployed');

    // ✅ Users by Level - Channels
    Route::get('/users/levels/all', [AdminController::class, 'users_by_level'])->name('admin.users.levels');
    Route::get('/users/levels/low', [AdminController::class, 'users_level_low'])->name('admin.users.levels.low');
    Route::get('/users/levels/medium', [AdminController::class, 'users_level_medium'])->name('admin.users.levels.medium');
    Route::get('/users/levels/high', [AdminController::class, 'users_level_high'])->name('admin.users.levels.high');
    Route::get('/users/levels/market', [AdminController::class, 'users_level_market'])->name('admin.users.levels.market');

    // ✅ Users Pending KYC
    Route::get('/users/pending-kyc', [AdminController::class, 'users_pending_kyc'])->name('admin.users.pending_kyc');

    // ✅ Active Users (completed KYC and onboarding)
    Route::get('/users/active', [AdminController::class, 'users_active'])->name('admin.users.active');

    Route::post('/kyc-levels/{key}/update', [AdminController::class, 'update_kyc_level'])->name('admin.kyc.update');
    Route::get('/orders/{order}', [OrderController::class, 'admin_order_show'])->name('admin.orders.show');
    Route::get('/user/repayment/{id}', [OrderController::class, 'admin_user_repayment'])->name('admin.users.repayments');
    Route::post('/user/destory/{id}', [AdminController::class, 'admin_user_destory'])->name('admin.users.destroy');
    Route::get('/user/view/{id}', [AdminController::class, 'admin_user_view'])->name('admin.users.view');
    Route::get('/platform', [AdminController::class, 'view_platform'])->name('platform');
    Route::get('/shop/cover', [AdminController::class, 'view_platform_shop'])->name('platform.shop');
    Route::post('/platform', [AdminController::class, 'save_platform'])->name('platform.update');
    Route::post('/platform/shop', [AdminController::class, 'save_platform_shop'])->name('platform.update.shop');
    Route::get('/loan/management', [AdminController::class, 'manage_loan'])->name('manage.loan');
    Route::get('/admin/loan-history/{user_id}', [AdminController::class, 'view_loan_history'])->name('admin.loan_history');

    Route::post('/admin/users/{id}/toggle-status', [UserDashboardController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
});


Route::middleware(['auth', 'is_admin', 'web'])->group(function () {


    Route::prefix('admin/admin_manager')->group(function () {
        Route::get('/view', [AdminController::class, 'admin_manager_view'])->name('admin_manager.view');
        Route::post('/save', [AdminController::class, 'admin_admin_manager_save'])->name('admin.admin_manager.save');
        Route::get('/all', [AdminController::class, 'admin_manager_all'])->name('admin_manager.all');
        Route::get('/edit/{id}', [AdminController::class, 'admin_manager_edit'])->name('admin_manager.edit');
        Route::post('/update/{id}', [AdminController::class, 'admin_manager_update'])->name('admin.admin_manager.update');
        Route::post('/delete/{id}', [AdminController::class, 'admin_admin_manager_delete'])->name('admin.admin_manager.delete');
        Route::post('/block/{id}', [AdminController::class, 'admin_admin_manager_block'])->name('admin.admin_manager.block');
    });

    Route::get('/admin/category/manage', [AdminController::class, 'category_view'])->name('category.view');
    Route::post('/admin/category/add', [AdminController::class, 'category_add'])->name('category.add');
    Route::post('/admin/category/delete/{id}', [AdminController::class, 'category_delete'])->name('category.delete');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('category.edit');
    Route::post('/admin/category/update/{id}', [AdminController::class, 'category_update'])->name('category.update');


    // Apply for Foodstuff Plan
    Route::get('/admin/product/add', [AdminController::class, 'product_view'])->name('admin.product.add');
    Route::get('/admin/dashboard', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');


    // Foodstuff Packages
    Route::get('/my-packages', [UserDashboardController::class, 'myPackages'])->name('user.my.packages');

    // Repayment
    Route::get('/repayments/schedule', [UserDashboardController::class, 'schedule'])->name('user.repayments.schedule');
    Route::get('/repayments/history', [UserDashboardController::class, 'history'])->name('user.repayments.history');

    // Delivery Status
    Route::get('/delivery-status', [UserDashboardController::class, 'deliveryStatus'])->name('user.delivery.status');
    Route::get('/admin/profile', [UserDashboardController::class, 'admin_profile'])->name('admin.profile');

    // Notifications
    Route::get('/notifications', [UserDashboardController::class, 'notifications'])->name('user.notifications');
    Route::get('/audit/log', [AdminController::class, 'audit_log'])->name('audit.log');


    Route::get('/admin/referral-settings', [ReferralController::class, 'settings'])->name('referral.settings');
Route::post('/admin/referral-settings/update', [ReferralController::class, 'updateSettings'])->name('referral.settings.update');
Route::get('/admin/history', [ReferralController::class, 'admin_history'])->name('admin.history');
Route::get('/admin/referral/leaderboard', [ReferralController::class, 'referralLeaderboard'])->name('admin.referral.leaderboard');

});

Route::post('/paystack/webhook', [PaymentWebhookController::class, 'handleWebhook']);


require __DIR__ . '/auth.php';
