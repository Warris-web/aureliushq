<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Food;
use App\Models\KycLevel;

use App\Models\LoanRepayment;
use App\Models\Order;
use App\Models\PlatformSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;



class UserDashboardController extends Controller
{
    public function browse(){
        $foods = Food::all();
        $settings = PlatformSetting::first();

        return view('user_new.shop', compact('foods','settings'));
    }
    public function category(){
        $categories = Category::withCount('foods')->get();
        return view('user_new.category', compact('categories'));
    }
    public function terms(){
        $kyc_info = KycLevel::where('key', Auth::user()->level)->first();
        $term = $kyc_info->term_condition;
        return view('user_new.term', compact('term'));
    }
    public function food_category($name){
        $category = Category::where('category_url', '=', $name)->first();
        $foods = Food::where('category', $category->id)->get(); // Get all available foods
        return view('user_new.shop_category', compact('foods', 'category'));
    }
    public function shop_detail($name){

        
        $food = Food::where('slug', $name)->first(); 
        return view('user_new.shop_detail', compact('food'));
    }
    public function my_cart(){
        $carts = Cart::where('user_id', '=', Auth::user()->id)->get();
        return view('user_new.cart', compact('carts'));
    }

    public function search_food(Request $request)
{
    $query = $request->input('query');

    $foods = Food::when($query, function ($q) use ($query) {
        $q->where('name', 'LIKE', '%' . $query . '%');
    })->get();

    return view('user_new.shop_search', compact('foods', 'query'));
}

public function user_profile(){
    return view('user_new.profile');
}
public function admin_profile(){
    return view('admin.profile');
}

public function updateAltContact(Request $request, $id)
{
    $request->validate([
        'alt_email' => 'nullable|email|max:255',
        'alt_phone' => 'nullable|string|max:20',
        'phone' => 'nullable|string|max:20',
    ]);

    $user = User::findOrFail($id);
    $user->alt_email = $request->alt_email;
    $user->alt_phone = $request->alt_phone;
    $user->phone = $request->phone;
    $user->save();


    return GeneralController::sendNotification('', 'success', '', 'contact details updated successfully!');

}



public function addAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $addresses = json_decode($user->home_address ?? '[]', true);
        $addresses[] = $request->address;

        $user->home_address = json_encode($addresses);
        $user->save();

        return GeneralController::sendNotification('', 'success', '', 'Address added successfully.');
    }

    /**
     * Delete an address by its index.
     */
    public function deleteAddress($index)
    {
        $user = Auth::user();
        $addresses = json_decode($user->home_address ?? '[]', true);

        if (isset($addresses[$index])) {
            unset($addresses[$index]);
            $user->home_address = json_encode(array_values($addresses));
            $user->save();

            return GeneralController::sendNotification('', 'success', '', 'Address deleted successfully.');
        }

        return GeneralController::sendNotification('', 'error', '', 'Address not found.');
    }

    /**
     * Change the user password.
     */
    public function changePassword(Request $request)
{
    try {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Grab the first validation error
        $errorMessage = collect($e->errors())->flatten()->first();

        return GeneralController::sendNotification('', 'error', '', $errorMessage);
    }

    $user = Auth::user();

    if (!\Hash::check($request->old_password, $user->password)) {
        return GeneralController::sendNotification('', 'error', '', 'Old password is incorrect.');
    }

    $user->password = \Hash::make($request->new_password);
    $user->save();

    return GeneralController::sendNotification('', 'success', '', 'Password changed successfully.');
}

    /**
     * Delete the user account.
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return GeneralController::sendNotification('', 'error', '', 'Password is incorrect.');
        }

        Auth::logout();
        $user->delete();

        return GeneralController::sendNotification('', 'success', '', 'Your account has been deleted.');
    }


    public function toggleStatus($id)
{
    $user = DB::table('users')->where('id', $id)->first();

    if (!$user) {
        return GeneralController::sendNotification('', 'error', '', 'User not found.');

    }

    $newStatus = ($user->account_status === 'active') ? 'inactive' : 'active';

    DB::table('users')->where('id', $id)->update([
        'account_status' => $newStatus,
        'updated_at' => now(),
    ]);
    return GeneralController::sendNotification('', 'success', '', 'User account status changed to '.$newStatus);

}



    public function sendOtp(Request $request)
    {
        $email = $request->email;
        $otp = rand(100000, 999999);

        Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

        // Send OTP to the email
        Mail::raw("Your verification code is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('Email Verification OTP');
        });

        return response()->json(['status' => 'ok', 'message' => 'OTP sent successfully']);
    }

    public function verifyOtp(Request $request)
    {
        $email = $request->email;
        $otp = $request->otp;

        $cachedOtp = Cache::get('otp_' . $email);

        if (!$cachedOtp) {
            return response()->json(['status' => 'error', 'message' => 'OTP expired or not found']);
        }

        if ($cachedOtp != $otp) {
            return response()->json(['status' => 'error', 'message' => 'Invalid OTP']);
        }

        Auth::user()->update(['alt_email' => $email]);
        Cache::forget('otp_' . $email);

        return response()->json(['status' => 'ok', 'message' => 'Alternative email verified and saved']);
    }

    public function updateAltPhone(Request $request)
    {
        $request->validate(['phone_alt' => 'required|string|max:20', 'phone' => 'required|string|max:20']);
        Auth::user()->update(['alt_phone' => $request->phone_alt, 'phone' => $request->phone]);
        return response()->json(['status' => 'ok', 'message' => 'Alternative Phone  Updated']);

    }

    public function uploadImage(Request $request)
{
    $request->validate([
        'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = Auth::user();

    // Define upload directory
    $uploadDir = public_path('uploads/profile/');
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Generate unique filename
    $file = $request->file('profile_image');
    $filename = time() . '.' . $file->getClientOriginalExtension();

    // Move file
    $file->move($uploadDir, $filename);

    // Store full relative path (not just filename)
    $fullPath = '/uploads/profile/' . $filename;

    // Update user record
    $user->update(['image' => $fullPath]);

    return GeneralController::sendNotification('', 'success', '', 'Profile Image Updated successfully.');
}


public function user_loan_history()
{

    // Get all repayment records for this user
    $repayments = LoanRepayment::where('user_id', Auth::user()->id)
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->get();


    // Or return a Blade view
    return view('user_new.loan', compact('repayments'));
}

}
