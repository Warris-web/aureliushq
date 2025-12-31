<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Food;


use App\Models\KycLevel;
use App\Models\LoanRepayment;
use App\Models\OperationalState;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Referral;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class AdminController extends Controller
{
    public function admin_dashboard()
    {
        $recent_orders = Order::where('has_paid_delivery_fee', 'yes')->latest()->paginate(10);

        $total_orders   = Order::count();
        $pending_orders   = Order::where('status', 'pending')->count();
        $total_users    = User::count();
        $total_revenues = Payment::where('status', 'success')->sum('amount');
        $total_products = Food::count();
        $total_loan_amount = User::sum('loan_balance');

        return view('admin.dashboard', [
            'recent_orders'  => $recent_orders,
            'total_orders'   => $total_orders,
            'pending_orders'   => $pending_orders,
            'total_users'    => $total_users,
            'total_revenues' => $total_revenues,
            'total_products' => $total_products,
            'total_loan_amount' => $total_loan_amount,
        ]);
    }


    public function product_view()
    {
        $categories = Category::all();

        return view('admin.product_add', compact('categories'));
    }
    public function product_edit($id)
    {
        $food = Food::where('id', $id)->first();
        $categories = Category::all();

        return view('admin.product_edit', compact('categories',  'food'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'required|string',
            'amount'          => 'required|string',
            'short_description' => 'nullable|string',
            'full_description'  => 'nullable|string',
            'image'             => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $dir = public_path('uploads/foods');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move($dir, $imageName);
            $imagePath = 'uploads/foods/' . $imageName;
        }

        // Generate Unique Slug
        $slug = Str::slug($request->name);

        // Save Food
        Food::create([
            'name'              => $request->name,
            'category'          => $request->category,
            'amount'          => $request->amount,
            'slug'              => $slug,
            'image'             => $imagePath,
            'short_description' => $request->short_description,
            'full_description'  => $request->full_description,
        ]);

        $notification = array(
            'message' => 'Food added successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function product_all()
    {
        $foods = Food::latest()->get();
        return view('admin.product_all', compact('foods'));
    }


    public function product_delete($id)
    {
        $food = Food::findOrFail($id);

        // Delete image if it exists
        $imagePath = public_path('uploads/foods/' . $food->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $food->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }


    public function product_update(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'required|string',
            'short_description' => 'nullable|string',
            'amount'            => 'required|numeric',
            'full_description'  => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $food = Food::findOrFail($id);

        $slug = Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;

        while (
            Food::where('slug', $slug)
            ->where('id', '!=', $id)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }
        // Ensure unique slug (ignoring current record)
        $count = Food::where('slug', 'like', "{$slug}%")
            ->where('id', '!=', $id)
            ->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($food->image && file_exists(public_path($food->image))) {
                unlink(public_path($food->image));
            }

            $image      = $request->file('image');
            $extension  = $image->getClientOriginalExtension();
            $fileName   = time() . '.' . $extension;
            $directory  = public_path('uploads/foods');

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $image->move($directory, $fileName);
            $food->image = 'uploads/foods/' . $fileName;
        }

        // Update fields
        $food->name              = $request->name;
        $food->slug              = $slug;
        $food->category          = $request->category;
        $food->short_description = $request->short_description;
        $food->amount            = $request->amount;
        $food->full_description  = $request->full_description;

        $food->save();

        $notification = array(
            'message' => 'Food Updated successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('foods.all')->with($notification);
    }


    public function category_view()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function category_add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $dir = public_path('uploads/categories/');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $imagePath = 'uploads/categories/' . $filename;
        }

        $url_slug = strtolower($request->name);
        $label_slug = preg_replace('/\s+/', '-', $url_slug);

        $category = new Category;
        $category->name = $request->name;
        $category->category_url = $label_slug;
        $category->image = $imagePath;
        $category->save();
        $notification = array(
            'message' => 'Category Sucessfully saved',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function category_delete($id)
    {
        $category = Category::findOrFail($id);

        // Check if any Food is linked to this category
        $foodExists = Food::where('category', $id)->exists();

        if ($foodExists) {
            // Prevent deletion and show error notification
            $notification = [
                'message' => 'This category cannot be deleted because it is linked to food items.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        // Safe to delete
        $category->delete();

        $notification = [
            'message' => 'Category Successfully Deleted',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }


    public function category_update(Request $request, $id)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $category_update = Category::findOrFail($id);

        $imagePath = $category_update->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $dir = public_path('uploads/categories/');
            if (!file_exists($dir)) mkdir($dir, 0755, true);
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $imagePath = 'uploads/categories/' . $filename;
        }

        $url_slug = strtolower($request->name);
        $label_slug = preg_replace('/\s+/', '-', $url_slug);

        $category_update->name = $request->name;
        $category_update->category_url = $label_slug;
        $category_update->image = $imagePath;
        $category_update->save();

        $notification = array(
            'message' => 'Category Successfully Updated',
            'alert-type' => 'success'
        );
        return redirect()->route('category.view')->with($notification);
    }


    public function admin_orders()
    {
        $orders = Order::where('has_paid_delivery_fee', 'yes')->orderBy('created_at', 'desc')->get();

        // Group orders by status and count dynamically
        $statusSummary = $orders->groupBy('status')->map(function ($group) {
            return $group->count();
        });

        // Totals
        $totalOrders = $orders->count();
        $totalSalesValue = $orders->sum('total_amount');

        return view('admin.orders', compact(
            'orders',
            'statusSummary',
            'totalOrders',
            'totalSalesValue'
        ));
    }


    public function pending_admin_orders()
    {
        $orders = Order::where('has_paid_delivery_fee', 'yes')->where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('admin.order_pending', compact('orders'));
    }
    public function approved_admin_orders()
    {
        $orders = Order::where('status', 'Approved')->orderBy('created_at', 'desc')->get();
        $operational_states = OperationalState::all();
        return view('admin.order_approved', compact('orders', 'operational_states'));
    }
    public function preparing_admin_orders()
    {
        $orders = Order::where('status', 'preparing')->orderBy('created_at', 'desc')->get();

        return view('admin.order_preparing', compact('orders'));
    }
    public function dispatched_admin_orders()
    {
        $orders = Order::where('status', 'ready')->orderBy('created_at', 'desc')->get();

        return view('admin.order_dispatched', compact('orders'));
    }
    public function delivered_admin_orders()
    {
        $orders = Order::where('status', 'delivered')->orderBy('created_at', 'desc')->get();

        return view('admin.order_delivered', compact('orders'));
    }
    public function denied_admin_orders()
    {
        $orders = Order::where('status', 'cancelled')->orderBy('created_at', 'desc')->get();

        return view('admin.order_cancelled', compact('orders'));
    }
    public function abandoned_admin_orders()
    {
        $orders = Order::where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return view('admin.order_abandoned', compact('orders'));
    }


    public function updateStatus_old(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status'   => 'required|string',
            'reason'   => 'nullable|string|max:1000',
        ]);

        try {
            $order = Order::findOrFail($request->order_id);
            $order->status = $request->status;
            $order->reason = $request->reason;
            $order->save();

            // Build HTML inline
            $html = "
            <h2>Hello {$order->user->name},</h2>
            <p>Your order <strong>#{$order->order_number}</strong> has been updated.</p>
            <p><strong>Status:</strong> " . ucfirst($order->status) . "</p>";

            if (!empty($order->reason)) {
                $html .= "<p><strong>Reason:</strong> {$order->reason}</p>";
            }

            $html .= "
            <p>Thank you for shopping with us!</p>
            <p><strong>" . config('app.name') . "</strong></p>
        ";

            // Send mail immediately
            Mail::send([], [], function ($message) use ($order, $html) {
                $message->to($order->user->email)
                    ->subject('Order #' . $order->id . ' Status Update')
                    ->html($html);
            });

            return redirect()->back()->with([
                'message'    => 'Order status updated and email sent!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message'    => 'Failed to update status. ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }


    public function updateStatus_olds(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status'   => 'required|string',
            'reason'   => 'nullable|string|max:1000',
        ]);

        try {
            $order = Order::findOrFail($request->order_id);
            $order->status = $request->status;
            $order->reason = $request->reason;

            // ✅ Extra check for loan adjustment
            if (strtolower($request->status) === 'approved' && strtolower($order->payment_method) === 'loan') {
                $user = User::findOrFail($order->user_id);

                $user->increment('loan_balance', $order->total_amount + ($order->total_amount * 0.10));
            }


            $order->save();

            // Build HTML inline
            $html = "
            <h2>Hello {$order->user->name},</h2>
            <p>Your order <strong>#{$order->order_number}</strong> has been updated.</p>
            <p><strong>Status:</strong> " . ucfirst($order->status) . "</p>";

            if (!empty($order->reason)) {
                $html .= "<p><strong>Reason:</strong> {$order->reason}</p>";
            }

            $html .= "
            <p>Thank you for shopping with us!</p>
            <p><strong>" . config('app.name') . "</strong></p>
        ";

            try {
                Mail::send([], [], function ($message) use ($order, $html) {
                    $message->to($order->user->email)
                        ->subject('Order #' . $order->id . ' Status Update')
                        ->html($html);
                });
            } catch (\Exception $e) {
            }
            // Send mail immediately

            return redirect()->back()->with([
                'message'    => 'Order status updated and email sent!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message'    => 'Failed to update status. ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }



    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status'   => 'required|string',
            'reason'   => 'nullable|string|max:1000',
        ]);

        try {
            $order = Order::findOrFail($request->order_id);
            $order->status = $request->status;
            $order->reason = $request->reason;
            if (!empty($request->operational_state)) {
                $order->operational_state = $request->operational_state;
            }

            // ✅ When status is delivered, mark timestamp
            if (strtolower($request->status) === 'delivered') {
                $order->delivered_at = now();
                $user = $order->user;

                ReferralController::completeReferral($user->id,$order->total_amount, "payment");

                // If order is paid by loan, create repayment plan
                if (strtolower($order->payment_method) === 'loan') {
                    $reference = strtoupper('servicecharge') . '_' . Str::uuid();

                    DB::table('payments')->insert([
                        'user_id'    => $user->id,
                        'package'    => 'service_charge',
                        'reference'  => $reference,
                        'amount'     => $order->total_amount * 0.10,
                        'status'     => 'success',
                        'gateway'    => 'service_charge',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $repaymentPlan = strtolower($order->repayment_plan ?? 'weekly');
                    $totalAmount = $order->total_amount + ($order->total_amount * 0.10); // 10% interest
                    $installments = 0;
                    $intervalDays = 0;
                    $user = $order->user;
                    $user->increment('loan_balance', $totalAmount);

                    switch ($repaymentPlan) {
                        case 'semi-weekly':
                            $installments = 8;
                            $intervalDays = 3; // Every 3 days
                            break;
                        case 'weekly':
                            $installments = 4;
                            $intervalDays = 7; // Every 7 days
                            break;
                        case 'bi-weekly':
                            $installments = 2;
                            $intervalDays = 14; // Every 14 days
                            break;
                        default:
                            $installments = 4;
                            $intervalDays = 7;
                            break;
                    }

                    $perPayment = round($totalAmount / $installments, 2);
                    $startDate = Carbon::parse($order->delivered_at);

                    for ($i = 0; $i < $installments; $i++) {
                        LoanRepayment::create([
                            'user_id' => $user->id,
                            'order_id' => $order->id,
                            'repayment_amount' => $perPayment,
                            'due_date' => $startDate->copy()->addDays($intervalDays * $i), // first installment = now
                            'status' => 'pending',
                        ]);
                    }
                }
            }

            // ✅ Extra check for loan adjustment
            if (strtolower($request->status) === 'approved' && strtolower($order->payment_method) === 'loan') {
            }

            $order->save();

            // ✅ Send notification email
            $html = "
            <h2>Hello {$order->user->name},</h2>
            <p>Your order <strong>#{$order->order_number}</strong> has been updated.</p>
            <p><strong>Status:</strong> " . ucfirst($order->status) . "</p>";

            if (!empty($order->reason)) {
                $html .= "<p><strong>Reason:</strong> {$order->reason}</p>";
            }

            $html .= "<p>Thank you for shopping with us!</p><p><strong>" . config('app.name') . "</strong></p>";

            try {
                Mail::send([], [], function ($message) use ($order, $html) {
                    $message->to($order->user->email)
                        ->subject('Order #' . $order->id . ' Status Update')
                        ->html($html);
                });
            } catch (\Exception $e) {
            }

            return redirect()->back()->with([
                'message'    => 'Order status updated successfully!',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message'    => 'Failed to update status. ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }



    public function admin_order_show($order)
    {
        $order = Order::where('order_number', $order)
            ->orWhere('id', $order)
            ->firstOrFail();


        dd($order);
        return view('admin.orders_detail', compact('order'));
    }


    public function payment_admin()
    {
        $payments = Payment::latest()->get();

        $totalAmount = Payment::where('status', 'success')->sum('amount');
        $totalPayments = Payment::count();
        $successfulPayments = Payment::where('status', 'success')->count();

        return view('admin.payment', compact(
            'payments',
            'totalAmount',
            'totalPayments',
            'successfulPayments'
        ));
    }

    public function payment_admin_wallet()
    {
        $payments = Payment::where('package', 'purchase')
            ->latest()
            ->get();

        $totalAmount = Payment::where('status', 'success')
            ->where('package', 'purchase')
            ->sum('amount');

        $totalPayments = Payment::where('package', 'purchase')->count();

        $successfulPayments = Payment::where('status', 'success')
            ->where('package', 'purchase')
            ->count();

        return view('admin.payment_purchase', compact(
            'payments',
            'totalAmount',
            'totalPayments',
            'successfulPayments'
        ));
    }
    public function payment_admin_service_charge()
    {
        $payments = Payment::where('package', 'service_charge')
            ->latest()
            ->get();

        $totalAmount = Payment::where('status', 'success')
            ->where('package', 'service_charge')
            ->sum('amount');

        $totalPayments = Payment::where('package', 'service_charge')->count();

        $successfulPayments = Payment::where('status', 'success')
            ->where('package', 'service_charge')
            ->count();

        return view('admin.service_charge', compact(
            'payments',
            'totalAmount',
            'totalPayments',
            'successfulPayments'
        ));
    }

    public function payment_admin_onboarding()
    {
        $payments = Payment::where('package', 'onboarding')
            ->latest()
            ->get();

        $totalAmount = Payment::where('status', 'success')
            ->where('package', 'onboarding')
            ->sum('amount');

        $totalPayments = Payment::where('package', 'onboarding')->count();

        $successfulPayments = Payment::where('status', 'success')
            ->where('package', 'onboarding')
            ->count();

        return view('admin.payment_onboarding', compact(
            'payments',
            'totalAmount',
            'totalPayments',
            'successfulPayments'
        ));
    }

    public function payment_admin_processing()
    {
        $payments = Payment::where('package', 'like', 'processing_fee%')
            ->latest()
            ->get();

        $totalAmount = Payment::where('status', 'success')
            ->where('package', 'like', 'processing_fee%')
            ->sum('amount');

        $totalPayments = Payment::where('package', 'like', 'processing_fee%')->count();

        $successfulPayments = Payment::where('status', 'success')
            ->where('package', 'like', 'processing_fee%')
            ->count();

        return view('admin.payment_processing', compact(
            'payments',
            'totalAmount',
            'totalPayments',
            'successfulPayments'
        ));
    }

    public function payment_admin_outstanding()
    {
        $payments = Payment::where('package', 'like', 'Outstanding Repayment%')
            ->latest()
            ->get();

        $totalAmount = Payment::where('status', 'success')
            ->where('package', 'like', 'Outstanding Repayment%')
            ->sum('amount');

        $totalPayments = Payment::where('package', 'like', 'Outstanding Repayment%')->count();

        $successfulPayments = Payment::where('status', 'success')
            ->where('package', 'like', 'Outstanding Repayment%')
            ->count();

        return view('admin.payment_outstanding', compact(
            'payments',
            'totalAmount',
            'totalPayments',
            'successfulPayments'
        ));
    }

    public function payment_admin_wallet_adjustment()
    {
        $payments = Payment::where(function ($q) {
                $q->where('package', 'Wallet Credit')
                  ->orWhere('package', 'Wallet Debit');
            })
            ->latest()
            ->get();

        $totalAmount = Payment::where('status', 'success')
            ->where(function ($q) {
                $q->where('package', 'Wallet Credit')
                  ->orWhere('package', 'Wallet Debit');
            })
            ->sum('amount');

        $totalPayments = Payment::where(function ($q) {
                $q->where('package', 'Wallet Credit')
                  ->orWhere('package', 'Wallet Debit');
            })
            ->count();

        $successfulPayments = Payment::where('status', 'success')
            ->where(function ($q) {
                $q->where('package', 'Wallet Credit')
                  ->orWhere('package', 'Wallet Debit');
            })
            ->count();

        return view('admin.payment_adjustment', compact(
            'payments',
            'totalAmount',
            'totalPayments',
            'successfulPayments'
        ));
    }


    public function kyc_level()
    {
        $levels = KycLevel::all();
        return view('admin.kyc_level', compact('levels'));
    }
    public function state_orders_preparing($name)
{
    // Fetch only orders that are 'preparing' for the given state
    $orders = Order::where('operational_state', $name)
        ->where('status', 'preparing')
        ->get();

    // Totals (only for preparing)
    $totalOrders = $orders->count();
    $totalSalesValue = $orders->sum('total_amount');

    // Since all are preparing, statusSummary is just one key
    $statusSummary = [
        'preparing' => $totalOrders,
    ];

    return view('admin.order_states_preparing', compact(
        'orders',
        'statusSummary',
        'totalOrders',
        'totalSalesValue',
        'name'
    ));
}


public function state_orders_ready($name)
{
    // Fetch only orders that are 'preparing' for the given state
    $orders = Order::where('operational_state', $name)
        ->where('status', 'ready')
        ->get();

    // Totals (only for preparing)
    $totalOrders = $orders->count();
    $totalSalesValue = $orders->sum('total_amount');

    // Since all are preparing, statusSummary is just one key
    $statusSummary = [
        'dispatched' => $totalOrders,
    ];

    return view('admin.order_states_ready', compact(
        'orders',
        'statusSummary',
        'totalOrders',
        'totalSalesValue',
        'name'
    ));
}


    public function manage_user(Request $request)
    {
        // Get filter parameters
        $employmentStatus = $request->get('employment_status');
        $kycStatus = $request->get('kyc_status');
        $emailVerified = $request->get('email_verified');
        $onboardingStatus = $request->get('onboarding_status');
        $accountStatus = $request->get('account_status');
        $level = $request->get('level');
        $search = $request->get('search');

        $query = User::query();

        // Apply employment status filter
        if ($employmentStatus) {
            $query->where('employee_status', $employmentStatus);
        }

        // Apply KYC status filter
        if ($kycStatus !== null && $kycStatus !== '') {
            if ($kycStatus === 'completed') {
                $query->where('has_done_kyc', 'yes');
            } elseif ($kycStatus === 'pending') {
                $query->where(function($q) {
                    $q->where('has_done_kyc', '!=', 'yes')
                      ->orWhereNull('has_done_kyc');
                });
            }
        }

        // Apply email verification filter
        if ($emailVerified !== null && $emailVerified !== '') {
            if ($emailVerified === 'verified') {
                $query->where('has_verified_email', 'yes');
            } elseif ($emailVerified === 'unverified') {
                $query->where(function($q) {
                    $q->where('has_verified_email', '!=', 'yes')
                      ->orWhereNull('has_verified_email');
                });
            }
        }

        // Apply onboarding status filter
        if ($onboardingStatus !== null && $onboardingStatus !== '') {
            if ($onboardingStatus === 'completed') {
                $query->where('has_paid_onboarding', 'yes');
            } elseif ($onboardingStatus === 'pending') {
                $query->where(function($q) {
                    $q->where('has_paid_onboarding', '!=', 'yes')
                      ->orWhereNull('has_paid_onboarding');
                });
            }
        }

        // Apply account status filter
        if ($accountStatus !== null && $accountStatus !== '') {
            if ($accountStatus === 'active') {
                $query->where('account_status', 'active');
            } elseif ($accountStatus === 'suspended') {
                $query->where('account_status', 'suspended');
            } elseif ($accountStatus === 'deactivated') {
                $query->where('account_status', 'deactivated');
            }
        }

        // Apply level filter
        if ($level) {
            $query->where('level', $level);
        }

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(50)->appends($request->all());

        // Get employment status summary
        $statusSummary = User::select('employee_status', DB::raw('count(*) as total'))
            ->groupBy('employee_status')
            ->get()
            ->keyBy('employee_status');

        // Get KYC status summary
        $kycSummary = [
            'completed' => User::where('has_done_kyc', 'yes')->count(),
            'pending' => User::where(function($q) {
                $q->where('has_done_kyc', '!=', 'yes')->orWhereNull('has_done_kyc');
            })->count(),
        ];

        // Get email verification summary
        $emailSummary = [
            'verified' => User::where('has_verified_email', 'yes')->count(),
            'unverified' => User::where(function($q) {
                $q->where('has_verified_email', '!=', 'yes')->orWhereNull('has_verified_email');
            })->count(),
        ];

        // Get onboarding status summary
        $onboardingSummary = [
            'completed' => User::where('has_paid_onboarding', 'yes')->count(),
            'pending' => User::where(function($q) {
                $q->where('has_paid_onboarding', '!=', 'yes')->orWhereNull('has_paid_onboarding');
            })->count(),
        ];

        return view('admin.user', compact(
            'users',
            'employmentStatus',
            'kycStatus',
            'emailVerified',
            'onboardingStatus',
            'accountStatus',
            'level',
            'search',
            'statusSummary',
            'kycSummary',
            'emailSummary',
            'onboardingSummary'
        ));
    }

    public function users_by_employment($status = null)
    {
        $employmentTypes = ['Student', 'Employed', 'Self-Employed', 'Unemployed'];

        if ($status && !in_array($status, $employmentTypes)) {
            $status = null;
        }

        $query = User::query();

        if ($status) {
            $query->where('employee_status', $status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(50);

        // Summary by employment status
        $statusSummary = User::select('employee_status', DB::raw('count(*) as total'))
            ->groupBy('employee_status')
            ->get()
            ->keyBy('employee_status');

        return view('admin.users_by_employment', compact(
            'users',
            'status',
            'employmentTypes',
            'statusSummary'
        ));
    }

    public function users_students()
    {
        return $this->users_by_employment('Student');
    }

    public function users_employed()
    {
        return $this->users_by_employment('Employed');
    }

    public function users_self_employed()
    {
        return $this->users_by_employment('Self-Employed');
    }

    public function users_unemployed()
    {
        return $this->users_by_employment('Unemployed');
    }

    // Users by Level (channels)
    public function users_by_level($level = null)
    {
        $levels = ['low', 'medium', 'high'];

        if ($level && !in_array($level, $levels)) {
            $level = null;
        }

        $query = User::query();
        if ($level) {
            $query->where('level', $level);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // Summary by level
        $levelSummary = User::select('level', DB::raw('count(*) as total'))
            ->groupBy('level')
            ->get()
            ->keyBy('level');

        return view('admin.users_by_level', compact('users', 'level', 'levels', 'levelSummary'));
    }

    public function users_level_low()
    {
        return $this->users_by_level('low');
    }

    public function users_level_medium()
    {
        return $this->users_by_level('medium');
    }

    public function users_level_high()
    {
        return $this->users_by_level('high');
    }

    public function users_level_market()
    {
        return $this->users_by_level('market');
    }

    /**
     * Show users who haven't completed KYC
     */
    public function users_pending_kyc(Request $request)
    {
        $search = $request->get('search');

        // Get users who haven't done KYC
        $query = User::where(function($q) {
            $q->where('has_done_kyc', '!=', 'yes')
              ->orWhereNull('has_done_kyc');
        });

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(50)->appends($request->all());

        // Get summary stats
        $totalPendingKyc = User::where(function($q) {
            $q->where('has_done_kyc', '!=', 'yes')
              ->orWhereNull('has_done_kyc');
        })->count();

        $totalCompletedKyc = User::where('has_done_kyc', 'yes')->count();

        $totalPendingOnboarding = User::where(function($q) {
            $q->where('has_paid_onboarding', '!=', 'yes')
              ->orWhereNull('has_paid_onboarding');
        })->count();

        $totalCompletedOnboarding = User::where('has_paid_onboarding', 'yes')->count();
        return view('admin.users_pending_kyc', compact(
            'users',
            'search',
            'totalPendingKyc',
            'totalCompletedKyc',
            'totalPendingOnboarding',
            'totalCompletedOnboarding'
        ));
    }

    /**
     * Show active users (completed KYC and onboarding)
     */
    public function users_active(Request $request)
    {
        $search = $request->get('search');

        // Get users who have completed both KYC and onboarding
        $query = User::where('has_done_kyc', 'yes')
                     ->where('has_paid_onboarding', 'yes');

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(50)->appends($request->all());

        // Get summary stats
        $totalActiveUsers = User::where('has_done_kyc', 'yes')
                                 ->where('has_paid_onboarding', 'yes')
                                 ->count();

        $totalUsers = User::count();

        return view('admin.users_active', compact(
            'users',
            'search',
            'totalActiveUsers',
            'totalUsers'
        ));
    }

    public function update_kyc_level(Request $request, $key)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'term_condition' => 'required|string',
            'repayment_period' => 'nullable|string',
            'credit_limit' => 'nullable|string',
            'credit_amount_limit' => 'required|integer|min:0',
        ]);

        $level = KycLevel::where('key', $key)->firstOrFail();

        $level->update($request->only([
            'title',
            'description',
            'repayment_period',
            'credit_limit',
            'credit_amount_limit',
            'term_condition'
        ]));

        return GeneralController::sendNotification('', 'success', '', 'KYC Level updated successfully!');
    }


    public function admin_user_destory($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting the currently logged-in user
        if ($user->id === auth()->id()) {
            return GeneralController::sendNotification('', 'error', '', 'You cannot delete your own account!');
        }

        $user->delete();

        return GeneralController::sendNotification('', 'success', '', 'User deleted successfully!');
    }

    public function admin_user_view($id)
    {
        $user = User::findOrFail($id);

        // User referral leaderboard (everyone)
        $leaderboard = User::select('users.id', 'users.first_name', 'users.last_name', 'users.email')
            ->withCount(['referrals as total_referrals' => function ($q) {
                $q->whereNotNull('referred_id');
            }])
            ->withSum(['histories as total_earnings' => function ($q) {
                $q->whereIn('type', ['referral_bonus', 'welcome_bonus', 'milestone_bonus']);
            }], 'amount')
            ->orderByDesc('total_earnings')
            ->orderByDesc('total_referrals')
            ->take(10)
            ->get();

        // Individual user's referrals
        $userReferrals = Referral::with('referred:id,first_name,last_name,email,created_at')
            ->where('referrer_id', $user->id)
            ->whereNotNull('referred_id')
            ->latest()
            ->get();

        // User’s earning history
        $history = $user->histories()
            ->whereIn('type', ['referral_bonus', 'welcome_bonus', 'milestone_bonus'])
            ->latest()
            ->get();

        return view('admin.user_view', compact('user', 'userReferrals', 'leaderboard', 'history'));
    }



    public function view_platform()
    {
        $settings = DB::table('platform_settings')->first();
        return view('admin.platform', compact('settings'));
    }
    public function view_platform_shop()
    {
        $settings = DB::table('platform_settings')->first();
        return view('admin.shop_cover', compact('settings'));
    }

    public function save_platform(Request $request)
    {
        // Validate inputs
        $request->validate([
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_slider_images.*' => 'nullable|string',
            'login_terms' => 'nullable|string',
            'support_phone' => 'nullable|string',
            'support_email' => 'nullable|email|max:100',
            'support_location' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|string|max:255',
            'social_x_tiktok' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
        ]);

        $settings = DB::table('platform_settings')->first();

        // Start with existing images that are still in the form
        $sliderImages = $request->input('existing_slider_images', []);

        if ($request->hasFile('slider_images')) {
            foreach ($request->file('slider_images') as $index => $image) {
                $dir = public_path('uploads/sliders');
                if (!is_dir($dir)) mkdir($dir, 0755, true);

                $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move($dir, $filename);

                $sliderImages[$index] = 'uploads/sliders/' . $filename;
            }
        }

        $sliderImages = array_replace(array_fill(0, 10, null), $sliderImages);
        $sliderImages = array_slice($sliderImages, 0, 10);

        // Prepare all data from the form
        $data = [
            'slider_images' => json_encode($sliderImages),
            'login_terms' => $request->login_terms ?? '',
            'support_phone' => $request->support_phone ?? '',
            'support_email' => $request->support_email ?? '',
            'support_location' => $request->support_location ?? '',
            'social_facebook' => $request->social_facebook ?? '',
            'social_x_tiktok' => $request->social_x_tiktok ?? '',
            'social_instagram' => $request->social_instagram ?? '',
            'updated_at' => now(),
        ];

        // Insert or update
        if ($settings) {
            DB::table('platform_settings')->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('platform_settings')->insert($data);
        }

        return GeneralController::sendNotification('', 'success', '', 'Platform settings updated successfully!');
    }
    public function save_platform_shop(Request $request)
    {
        $request->validate([
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_slider_images.*' => 'nullable|string'
        ]);

        $sliderImages = $request->input('existing_slider_images', []);

        if ($request->hasFile('slider_images')) {
            foreach ($request->file('slider_images') as $index => $image) {
                $dir = public_path('uploads/sliders');
                if (!is_dir($dir)) mkdir($dir, 0755, true);

                $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move($dir, $filename);

                $sliderImages[$index] = 'uploads/sliders/' . $filename;
            }
        }

        $sliderImages = array_replace(array_fill(0, 10, null), $sliderImages);
        $sliderImages = array_slice($sliderImages, 0, 10);

        DB::table('platform_settings')->updateOrInsert(
            ['id' => 1],
            ['shop_images' => json_encode($sliderImages), 'updated_at' => now()]
        );

        return GeneralController::sendNotification('', 'success', '', 'Shop Cover settings updated successfully!');
    }


    public function manage_loan()
    {
        $users = DB::table('users')
            ->join('loan_repayments', 'users.id', '=', 'loan_repayments.user_id')
            ->where('users.loan_balance', '>', 0)
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.alt_phone',
                'users.loan_balance',
                DB::raw('MIN(loan_repayments.due_date) as next_due_date')
            )
            ->groupBy(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.alt_phone',
                'users.loan_balance'
            )
            ->orderBy('next_due_date', 'asc')
            ->get();

        return view('admin.loan', compact('users'));
    }


    public function view_loan_history($user_id)
    {
        $user = User::findOrFail($user_id);

        // Group repayments by order_id
        $repayments = LoanRepayment::where('user_id', $user_id)
            ->orderBy('due_date', 'asc')
            ->get()
            ->groupBy('order_id'); // <-- Group repayments by order_id

        return view('admin.loan_history', compact('user', 'repayments'));
    }


    public function manage_wallet(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'reason' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $amount = $request->amount;
        $action = $request->action; // 'on' = add, 'off' = remove
        $reason = trim($request->reason);

        $reference = strtoupper("WALLET_") . Str::uuid();

        // Generate narration text (conditionally include reason)
        $narration = $action === 'on'
            ? "₦" . number_format($amount, 2) . " was credited to {$user->first_name}'s wallet by Admin"
            : "₦" . number_format($amount, 2) . " was debited from {$user->first_name}'s wallet by Admin";

        if (!empty($reason)) {
            $narration .= ". Reason: {$reason}.";
        } else {
            $narration .= ".";
        }

        // Wallet operation
        if ($action === 'on') {
            $package = "Wallet Credit";
            $user->increment('wallet_balance', $amount);
        } else {
            if ($user->wallet_balance < $amount) {
                return GeneralController::sendNotification('', 'error', '', 'Insufficient wallet balance to remove.');
            }
            $user->decrement('wallet_balance', $amount);
            $package = "Wallet Debit";

        }

        // Record transaction
        DB::table('payments')->insert([
            'user_id'    => $user->id,
            'package'    => $package,
            'reference'  => $reference,
            'amount'     => $amount,
            'status'     => 'success',
            'gateway'    => 'Wallet',
            'response'   => $narration,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Prepare email
        $primaryEmail = $user->email ?? null;
        $altEmail = $user->alt_email ?? null;
        $emails = array_filter([$primaryEmail, $altEmail]);

        if (!empty($emails)) {
            $subject = $action === 'on'
                ? 'Admin Wallet Credit Notification'
                : 'Admin Wallet Debit Notification';

            $html = "
                <h2>Hello {$user->first_name} {$user->last_name},</h2>
                <p>Your wallet has been <strong>" . ($action === 'on' ? 'credited' : 'debited') . "</strong>.</p>
                <p><strong>Amount:</strong> ₦" . number_format($amount, 2) . "</p>
                <p><strong>New Balance:</strong> ₦" . number_format($user->wallet_balance, 2) . "</p>";

            if (!empty($reason)) {
                $html .= "<p><strong>Reason:</strong> {$reason}</p>";
            }

            $html .= "
                <p><strong>Reference:</strong> {$reference}</p>
                <p>Thank you for using our platform.</p>
            ";

            try {
                app(LoanReminderController::class)
                    ->sendEmail($emails, $subject, $html);
            } catch (\Throwable $e) {
            }
        }

        return GeneralController::sendNotification('', 'success', '', 'Wallet successfully updated for ' . $user->email . '.');
    }



    public function admin_manager_view()
    {
        $users = User::whereNotNull('user_role')->where('user_role', 'admin_manager')->get();
        return view('admin.admin_manager', compact('users'));
    }

    public function admin_admin_manager_save(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'user_roles' => 'required|array',
        ]);

        $check_email = User::where('email', $request->email)->first();
        if ($check_email) {
            return GeneralController::sendNotification('', 'error', '', 'Email Already Exist:' . $check_email->email . '.');
        }


        // Generate random password
        $min = 100000;
        $max = 999999;
        $randomNumber = rand($min, $max);
        $password = $request->first_name . "" . $randomNumber;

        // Create the user
        $add_user = new User;
        $add_user->first_name = $request->first_name;
        $add_user->last_name = $request->last_name;
        $add_user->email = $request->email;
        $add_user->phone = $request->phone;
        $add_user->permissions = json_encode($request->user_roles);
        $add_user->user_role = 'admin_manager';
        $add_user->password = Hash::make($password);
        $add_user->save();

        // Prepare plain text email
        $message = "Dear {$request->first_name} {$request->last_name},\n\n" .
            "Your admin manager account has been created successfully.\n\n" .
            "Login details:\n" .
            "Email: {$request->email}\n" .
            "Password: {$password}\n\n" .
            "Please login and change your password after first login.\n\n" .
            "Regards,\n" .
            "Aurelius Team";

        // Send plain text email
        try {
            Mail::raw($message, function ($mail) use ($request) {
                $mail->to($request->email)
                    ->subject('Your Admin Manager Account Details');
            });
        } catch (\Throwable $e) {
        }

        return GeneralController::sendNotification('', 'success', '', 'Admin Manager Successfully saved and email sent');
    }


    public function admin_admin_manager_delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return GeneralController::sendNotification('', 'success', '', 'Admin Manager Successfully deleted');
    }

    public function admin_manager_update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'user_roles' => 'required|array',
        ]);

        $update_user = User::findOrFail($id);
        $update_user->first_name = $request->first_name;
        $update_user->last_name = $request->last_name;
        $update_user->email = $request->email;
        $update_user->phone = $request->phone;
        $update_user->user_role = 'admin_manager';
        $update_user->permissions = json_encode($request->user_roles);
        $update_user->save();
        return GeneralController::sendNotification('', 'success', '', 'Admin Manager Successfully updated');
    }


    public function audit_log()
    {
        $logs = DB::table('audit_logs')
            ->leftJoin('users', 'users.id', '=', 'audit_logs.user_id')
            ->select(
                'audit_logs.*',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone'
            )
            ->orderByDesc('audit_logs.id')
            ->get();

        return view('admin.audit_logs', compact('logs'));
    }
}
