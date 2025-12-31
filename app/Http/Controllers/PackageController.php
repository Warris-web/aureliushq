<?php

namespace App\Http\Controllers;

use App\Models\LoanRepayment;
use App\Models\OperationalState;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Dojah\Client; // the correct SDK class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PackageController extends Controller
{

    protected $dojah;
    protected $baseUrl = "https://api.paystack.co";

    /**
     * Initialize Dojah SDK only when needed
     */
    private function getDojahClient(): Client
    {
        if (!$this->dojah) {
            $this->dojah = new Client(
                Authorization: env('DOJAH_API_KEY'),
                AppId: env('DOJAH_APP_ID'),
            );
        }
        return $this->dojah;
    }




    public function launch(Request $request, $level = null)
    {
        // Get level from route parameter or request body
        $package = $level ?? $request->get('package', 'basic');

        $widgetId = env(match ($package) {
            'medium'       => 'DOJAH_WIDGET_MEDIIUM',
            'market_woman' => 'DOJAH_WIDGET_BUSINESS',
            'high'         => 'DOJAH_WIDGET_HIGH',
            default        => 'DOJAH_WIDGET_BASIC',
        });

        $user = Auth::user();

        $reference = $user->id . '_' . \Illuminate\Support\Str::uuid();

        $user->update([
            'kyc_reference' => $reference,
            'kyc_status'    => 'pending',
            'level'         => $package,
            'state'         => $request->state,
            'lga'           => $request->lga,
        ]);

        return view('user.kyc_start', [
            'reference' => $reference,
            'widgetId'  => $widgetId,
            'appId'     => env('DOJAH_APP_ID'),
            'publicKey' => env('DOJAH_PUBLIC_KEY'),
            'user'      => $user
        ]);
    }



    public function handleWebhook_old(Request $request)
    {
        try {
            // Parse payload safely
            $payload = $request->all();
            if (empty($payload)) {
                $payload = json_decode($request->getContent(), true);
            }

            Log::info('Dojah Webhook Payload:', [
                'raw' => $request->getContent(),
                'parsed' => $payload,
            ]);

            // Ensure Completed status
            if (($payload['verification_status'] ?? '') !== 'Completed') {
                return response()->json(['message' => 'Verification not completed'], 200);
            }

            // Extract reference
            $reference = $payload['metadata']['reference'] ?? null;
            if (!$reference) {
                return response()->json(['message' => 'Reference not found'], 400);
            }

            $user = User::where('kyc_reference', $reference)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            // Update names
            $firstName = $payload['data']['government_data']['data']['bvn']['entity']['first_name'] ?? null;
            $lastName  = $payload['data']['government_data']['data']['bvn']['entity']['last_name'] ?? null;

            $user->first_name   = $firstName ?? $user->first_name;
            $user->last_name    = $lastName ?? $user->last_name;
            $user->kyc_response = json_encode($payload);
            $user->has_done_kyc = 'yes';
            $user->save();

            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            Log::error('Dojah Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }


    public function handleWebhook(Request $request)
    {
        try {
            $payload = $request->all();
            if (empty($payload)) {
                $payload = json_decode($request->getContent(), true);
            }


            if (($payload['verification_status'] ?? '') !== 'Completed') {
                return response()->json(['message' => 'Verification not completed'], 200);
            }

            $email = $payload['data']['email']['data']['email'] ?? null;
            if (!$email) {
                return response()->json(['message' => 'Email not found in payload'], 400);
            }

            $user = User::where('kyc_reference', $payload['metadata']['reference'] ?? '')->first();
            // $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $bvn       = $payload['data']['government_data']['data']['bvn']['entity']['bvn'] ?? null;
            $firstName = $payload['data']['government_data']['data']['bvn']['entity']['first_name'] ?? null;
            $lastName  = $payload['data']['government_data']['data']['bvn']['entity']['last_name'] ?? null;

            $user->first_name   = $firstName ?? $user->first_name;
            $user->last_name    = $lastName ?? $user->last_name;
            $user->bvn          = $bvn ?? $user->bvn;
            $user->kyc_response = json_encode($payload);
            $user->kyc_status   = 'completed';
            $user->has_done_kyc = 'yes';
            $user->save();

            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Server error'], 500);
        }
    }




    public function complete()
    {
        $user = Auth::user();

        if ($user->has_done_kyc === 'yes') {
            return GeneralController::sendNotification(
                'onboarding_page',
                'success',
                'Onboarding Complete!',
                'Your KYC completed successfully!'
            );
        }

        return GeneralController::sendNotification(
            'dashboard',
            'info',
            'Onboarding In Progress!',
            'Your KYC verification was successful. Our System will Update your info Shortly'
        );
    }


    public function complete_old(Request $request)
    {
        $user = Auth::user();
        $reference = $user->kyc_reference;

        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => env('DOJAH_API_KEY'),
                'AppId'         => env('DOJAH_APP_ID'),
            ]
        ]);

        $response = $client->get("https://sandbox.dojah.io/api/v1/kyc/verification?reference=$reference");
        dd($response);

        $data = json_decode($response->getBody(), true);

        $user->kyc_response = json_encode($data);
        $user->has_done_kyc = 'yes';
        $user->save();

        return GeneralController::sendNotification('dashboard', 'success', 'Onboarding Complete!', 'Your onboarding payment was successful. You can now complete KYC.');
    }

    // public function complete(Request $request)
    // {
    // // Debug everything coming in

    //     $user = Auth::user();

    //     // Dojah will usually return reference_id or verification_id in request
    //     $verificationId = $request->get('verification_id');
    //     $referenceId    = $request->get('reference_id');

    //     if (!$verificationId && !$referenceId) {
    //         return GeneralController::sendNotification('dashboard', 'error', 'Verification Failed', 'No verification_id or reference_id provided.');
    //     }

    //     $client = new \GuzzleHttp\Client([
    //         'headers' => [
    //             'Authorization' => env('DOJAH_API_KEY'),
    //             'AppId'         => env('DOJAH_APP_ID'),
    //         ]
    //     ]);

    //     $url = "https://sandbox.dojah.io/api/v1/kyc/verification?"
    //          . ($verificationId ? "verification_id=$verificationId" : "reference_id=$referenceId");

    //     $response = $client->get($url);
    //     $data = json_decode($response->getBody(), true);

    //     dd($response);
    //     $user->update([
    //         'kyc_response' => json_encode($data),
    //         'has_done_kyc' => 'yes',
    //     ]);

    //     return GeneralController::sendNotification('dashboard', 'success', 'Onboarding Complete!', 'KYC verification successful.');
    // }


    // private static function get_base_url()
    // {
    //     return 'https://sandboxapi.fincra.com';
    // }


    private static function get_base_url()
{
    return 'https://api.fincra.com';
}

    public function showForm()
    {
        $packages = [
            'low' => ['name' => 'Low-Level Users', 'limit' => '₦10k-₦50k', 'period' => '30 days', 'options' => ['Weekly', 'Semi-Weekly', 'Bi-Weekly', 'Outright']],
            'mid' => ['name' => 'Mid-Level Users', 'limit' => '₦51k-₦200k', 'period' => '30 days', 'options' => ['Weekly', 'Semi-Weekly', 'Bi-Weekly', 'Outright']],
            // 'high' => ['name' => 'High-Level Users', 'limit' => '₦201k-₦500k+', 'period' => '60 days', 'options' => ['Weekly', 'Semi-Weekly', 'Bi-Weekly', 'Monthly', 'Outright']],
            'high' => ['name' => 'High Level & Market Traders', 'limit' => 'Flexible', 'period' => 'Daily/Weekly', 'options' => ['Daily', 'Weekly', 'Semi-Flexible']],
        ];
        return view('auth.package', compact('packages'));
    }

    private function createFincraPayment($user, $amount, $reference)
    {
        $redirectUrl = route('package.callback');

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => env('FINCRA_SECRET_KEY'),
            'x-business-id' => env('FINCRA_BUSINESS_ID'),
            'x-pub-key' => env('FINCRA_PUBLIC_KEY'),
            'content-type' => 'application/json'
        ])->post($this->get_base_url() . '/checkout/payments', [
            "currency"       => "NGN",
            "amount"         => $amount,
            "customer"       => [
                "name"  => $user->first_name . " " . $user->last_name,
                "email" => $user->email
            ],
            "paymentMethods" => ["bank_transfer"],
            "feeBearer"      => "customer",
            "redirectUrl"    => $redirectUrl,
            "reference"      => $reference,
        ])->json();

        return isset($response['data']['link'])
            ? ['url' => $response['data']['link']]
            : [];
    }


    private function createPaystackPayment($user, $amount, $reference)
    {
        $redirectUrl = route('package.callback');

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->post('https://api.paystack.co/transaction/initialize', [
                "email"        => $user->email,
                "amount"       => $amount * 100,
                "reference"    => $reference,
                "callback_url" => $redirectUrl,
            ])->json();

        return (isset($response['status']) && $response['status'] === true)
            ? ['url' => $response['data']['authorization_url']]
            : [];
    }




    public function startPayment(Request $request)
    {
        $gateway = $request->query('gateway', 'fincra'); // Default gateway is Fincra
        $user = Auth::user();

        // Generate reference with gateway prefix
        $reference = strtoupper($gateway) . '_' . Str::uuid();
        $amount = 1000;
        // Save pending payment
        DB::table('payments')->insert([
            'user_id'    => $user->id,
            'package'    => 'onboarding',
            'reference'  => $reference,
            'amount'     => $amount,
            'status'     => 'pending',
            'gateway'    => $gateway,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ✅ Call the correct payment creation method
        $paymentResponse = ($gateway === 'paystack')
            ? $this->createPaystackPayment($user,  $amount, $reference)
            : $this->createFincraPayment($user, $amount, $reference);

        // ✅ Normalize the payment URL (both methods must return ['url' => '...'])
        if (empty($paymentResponse['url'])) {
            return GeneralController::sendNotification('', 'error', 'Onboarding Payment!', 'Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance');
        }

        // ✅ Redirect to gateway URL
        return redirect($paymentResponse['url']);
    }


    public function pay_processing_fee(Request $request)
    {
        $gateway = $request->payment_type;
        $id = $request->order_id;
        $user = Auth::user();
        $amount = 1000;
        $reference = strtoupper($gateway) . '_' . Str::uuid();

        // Save pending payment
        DB::table('payments')->insert([
            'user_id'    => $user->id,
            'package'    => 'processing_fee|' . $id,
            'reference'  => $reference,
            'amount'     => $amount,
            'status'     => 'pending',
            'gateway'    => $gateway,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Call the correct payment creation method
        $paymentResponse = ($gateway === 'paystack')
            ? $this->createPaystackPayment($user, $amount, $reference)
            : $this->createFincraPayment($user, $amount, $reference);

        if (empty($paymentResponse['url'])) {
            return response()->json([
                'status'  => 'error',
                'title'   => 'Processing Fee Payment!',
                'message' => 'Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'url'    => $paymentResponse['url'],
            'reference' => $reference,
        ]);
    }
    public function pay_processing_fee_onspot(Request $request)
    {
        $data = $request->all();   // grab all input from fetch()

        $gateway = $data['payment_type'];
        $id = $data['order_id'];
        $user = Auth::user();
        $amount = 1000;
        $reference = strtoupper($gateway) . '_' . Str::uuid();

        if ($gateway === 'wallet') {
            if (Auth::user()->wallet_balance <= 1000) {
                $availableBalance = number_format(Auth::user()->wallet_balance, 2);

                return response()->json([
                    'status'  => 'error',
                    'title'   => 'Processing Fee Payment',
                    'message' => "Insufficient balance in your Aurelius Wallet. Your current balance is ₦{$availableBalance}. Kindly fund your wallet or try another payment option. Thank you.",
                ], 500);
            }
            $user->decrement('wallet_balance', 1000);

            DB::table('payments')->insert([
                'user_id'    => $user->id,
                'package'    => 'processing_fee|' . $id,
                'reference'  => $reference,
                'amount'     => $amount,
                'status'     => 'success',
                'gateway'    => $gateway,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Order::where('id', $id)
                ->update(['has_paid_delivery_fee' => 'yes']);
            return response()->json([
                'status'  => 'success',
                'title'   => 'Processing Fee Deducted',
                'message' => "A processing fee of ₦1,000 has been successfully deducted from your Aurelius Wallet.
                                  Your new wallet balance is ₦" . number_format($user->fresh()->wallet_balance, 2) . ".",
            ]);
        } else {
            DB::table('payments')->insert([
                'user_id'    => $user->id,
                'package'    => 'processing_fee|' . $id,
                'reference'  => $reference,
                'amount'     => $amount,
                'status'     => 'pending',
                'gateway'    => $gateway,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $paymentResponse = ($gateway === 'paystack')
            ? $this->createPaystackPayment($user, $amount, $reference)
            : $this->createFincraPayment($user, $amount, $reference);

        if (empty($paymentResponse['url'])) {
            return response()->json([
                'status'  => 'error',
                'title'   => 'Processing Fee Payment!',
                'message' => 'Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance',
            ], 500);
        }

        return response()->json([
            'status'    => 'success',
            'url'       => $paymentResponse['url'],
            'reference' => $reference,
        ]);
    }


    /**
     * ✅ Handle Fincra Payment Callback
     */
    private function verifyPaystackPayment($reference)
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}")
            ->json();

        if (isset($response['status']) && $response['status'] === true && $response['data']['status'] === 'success') {
            return ['status' => true];
        }
        return ['status' => false];
    }

    /**
     * ✅ Verify Fincra Payment
     */
    private function verifyFincraPayment($reference)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'api-key' => env('FINCRA_SECRET_KEY'),
            'x-business-id' => env('FINCRA_BUSINESS_ID'),
            'x-pub-key' => env('FINCRA_PUBLIC_KEY'),
        ])->get($this->get_base_url() . '/checkout/payments/merchant-reference/' . $reference)
            ->json();
        if (isset($response['status']) && $response['status'] === true) {
            $status = strtolower($response['data']['status'] ?? '');
            return ['status' => ($status === 'success' || $status === 'pending')];
        }
        return ['status' => false];
    }

    /**
     * ✅ Callback for Both Paystack & Fincra
     */

    public static function checkProcessingFee($string)
    {
        if (strpos($string, 'processing_fee|') !== false) {
            $parts = explode('|', $string);

            // make sure there's a value after "|"
            if (isset($parts[1]) && is_numeric($parts[1])) {
                return [
                    'status' => true,
                    'id' => (int)$parts[1]
                ];
            }
        }

        return [
            'status' => false,
            'id' => null
        ];
    }
    public static function check_loan_repayment($string)
    {
        if (strpos($string, 'Outstanding Repayment|') !== false) {
            $parts = explode('|', $string);

            // make sure there's a value after "|"
            if (isset($parts[1]) && is_numeric($parts[1])) {
                return [
                    'status' => true,
                    'id' => (int)$parts[1]
                ];
            }
            if (isset($parts[1]) && !is_numeric($parts[1])) {
                return [
                    'status' => true,
                    'id' => 'all'
                ];
            }
        }

        return [
            'status' => false,
            'id' => null
        ];
    }

    public function paymentCallback(Request $request)
    {
        $reference = $request->query('reference');
        $payment = DB::table('payments')->where('reference', $reference)->first();

        if (!$payment) {
            return GeneralController::sendNotification('', 'error', ' Online Payment!', 'Payment record not found.');
        }
        $check_package = self::checkProcessingFee($payment->package);
        $check_loan_repayment = self::check_loan_repayment($payment->package);


        // ✅ Determine which gateway to verify
        $verifyResponse = ($payment->gateway === 'paystack')
            ? $this->verifyPaystackPayment($reference)
            : $this->verifyFincraPayment($reference);

        if ($verifyResponse['status']) {
            DB::table('payments')->where('reference', $reference)->update([
                'status'     => 'success',
                'updated_at' => now()
            ]);
            if ($check_package['status']) {
                Order::where('id', $check_package['id'])
                    ->update(['has_paid_delivery_fee' => 'yes']);
            }

            if ($check_loan_repayment['status'] && is_numeric($check_loan_repayment['id'])) {
                $repayment_info = LoanRepayment::where('id', $check_loan_repayment['id'])->first();
                $user_info = User::findOrFail($payment->user_id);
                $user_info->decrement('loan_balance', $repayment_info->repayment_amount);
                $repayment_info->status = 'paid';
                $repayment_info->save();


                try {
                    $primaryEmail = $user_info->email;
                    $altEmail = $user_info->alt_email;
                    $html = "
            <h2>Hello {$user_info->first_name} {$user_info->last_name},</h2>
            <p>Your Outstanding repayment of <strong>₦" . number_format($repayment_info->repayment_amount, 2) . "</strong> has been successfully processed.</p>
            <p>Thank you for staying consistent with your payments.</p>
        ";
                    $loan_instance = new LoanReminderController();
                    // Send to both emails if available
                    $loan_instance->sendEmail([$primaryEmail, $altEmail], "Outstanding Payment Successful", $html);
                } catch (\Throwable $e) {
                }
            }


            if ($check_loan_repayment['status'] && $check_loan_repayment['id']==='all') {
                $user_info = User::findOrFail($payment->user_id);
                $user_info->decrement('loan_balance', $payment->amount);
                LoanRepayment::where('user_id', $payment->user_id)->update(['status' => 'paid']);
                try {
                    $primaryEmail = $user_info->email;
                    $altEmail = $user_info->alt_email;
                    $html = "
            <h2>Hello {$user_info->first_name} {$user_info->last_name},</h2>
            <p>Your Outstanding repayment of <strong>₦" . number_format($payment->amount, 2) . "</strong> has been successfully processed.</p>
            <p>Thank you for staying consistent with your payments.</p>
        ";
                    $loan_instance = new LoanReminderController();
                    // Send to both emails if available
                    $loan_instance->sendEmail([$primaryEmail, $altEmail], "Outstanding Payment Successful", $html);
                } catch (\Throwable $e) {
                }
            }


            User::findOrFail($payment->user_id)->update(['has_paid_onboarding' => 'yes']);

            // Send account activation email after onboarding payment
            if (!$check_package['status'] && !$check_loan_repayment['status']) {
                try {
                    $user_info = User::findOrFail($payment->user_id);
                    Mail::to($user_info->email)->send(new \App\Mail\AccountActivatedMail($user_info));
                } catch (\Exception $e) {
                    Log::error('Failed to send account activated email: ' . $e->getMessage());
                }
            }

            if ($check_package['status']) {
                return GeneralController::sendNotification('user.orders', 'success', 'Online  Payment!', 'Payment successful!');
            } elseif ($check_loan_repayment['status']) {
                return GeneralController::sendNotification('user.loan', 'success', 'Online  Payment!', 'Payment successful!');
            } else {
                ReferralController::completeReferral($payment->user_id);
                return GeneralController::sendNotification('dashboard', 'success', 'Online  Payment!', 'Payment successful!');
            }
        } else {
            DB::table('payments')->where('reference', $reference)->update([
                'status'     => 'failed',
                'updated_at' => now()
            ]);
            if ($check_package['status']) {
                return GeneralController::sendNotification('user.orders', 'error', 'Online Payment!', 'Payment verification failed.');
            } else {
                return GeneralController::sendNotification('dashboard', 'error', 'Online Payment!', 'Payment verification failed.');
            }
        }
    }



    public function webhook(Request $request)
    {
        // $data = json_decode('{"metadata": {"ipinfo": {"status": "success", "country": "Nigeria", "city": "Lagos", "district": "", "zip": "EC1N", "lat": 6.45411, "lon": 3.39464, "timezone": "Europe/London", "isp": "Airtel Networks Limited", "org": "Uni Broadband LLC", "as": "AS36873 NB NETWORKS GROUP LLC", "mobile": false, "proxy": false, "hosting": false, "query": "105.113.112.1", "region_name": "Lagos"}, "device_info": "Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36"}, "data": {"index": {"data": {}, "message": "Successfully continued to the main checks.", "status": true}, "countries": {"data": {"country": "Nigeria"}, "message": "Successfully continued to the next step.", "status": true}, "government_data": {"data": {"bvn": {"entity": {"customer": "739f857b-c2e4-41de-9ad3-1d18fe39e6ef", "app_id": "692f126a373b50511586047b", "bvn": "22176364160", "first_name": "MICHEAL", "last_name": "GEORGE", "middle_name": "MOSES", "gender": "Male", "date_of_birth": "1995-04-03", "phone_number1": "09078062074", "phone_number2": null, "image_url": "https://images.dojah.io/bvn_22176364160_1765810395.jpg", "email": null, "enrollment_bank": null, "enrollment_branch": null, "level_of_account": null, "lga_of_origin": null, "lga_of_residence": null, "marital_status": null, "name_on_card": null, "nationality": null, "nin": null, "registration_date": null, "residential_address": null, "state_of_origin": null, "state_of_residence": null, "title": null, "type": "basic", "xc": "c", "sc": true, "watch_listed": null, "createdAt": "2025-12-15T14:53:16.000Z", "updatedAt": "2025-12-15T14:53:16.000Z"}}}, "message": "", "status": true}, "address": {"message": "Successfully verified your address", "status": true, "data": {"location": {"address_location": {"latitude": "6.5260466", "longitude": "3.3425134", "name": "2 Bamgboye Street, Lagos, Nigeria"}, "address_pdf": ""}}}, "id": {"data": {"id_url": "https://images.dojah.io/image_69401fb19cd9bd004703ed5fid_1765810571.jpg", "back_url": "", "id_data": {"first_name": "MICHEAL", "last_name": "GEORGE", "middle_name": "MOSES", "nationality": "NIGERIAN", "mrz_status": "", "expiry_date": "2029-10-14", "document_type": "passport", "document_number": "B03881269", "date_of_birth": "1995-04-03", "date_issued": "2024-10-15", "extras": ""}}, "status": true, "message": "Successfully verified your id"}, "selfie": {"data": {"selfie_url": "https://images.dojah.io/image_69401fb19cd9bd004703ed5fface_1765810738.jpg", "liveness_score": null, "match_score": 99.0}, "message": "Successfully validated your liveness", "status": true}}, "id_type": "BVN", "value": "B03881269", "id_url": "https://images.dojah.io/image_69401fb19cd9bd004703ed5fid_1765810571.jpg", "back_url": "", "message": "Successfully completed the verification.", "reference_id": "DJ-1AA81D64AD", "widget_id": "692f1331373b5051158604a9", "verification_mode": "LIVENESS", "verification_type": "PASSPORT_ID", "verification_value": "B03881269", "verification_url": "https://app.dojah.io/verifications/bio-data/ee15325c-eceb-463d-9cb1-9a1fcfe7541b", "selfie_url": "https://images.dojah.io/image_69401fb19cd9bd004703ed5fface_1765810738.jpg", "status": true, "aml": {"status": false}, "verification_status": "Completed"}');
        // // $data = json_decode('{"metadata": {"ipinfo": {"status": "success", "country": "Nigeria", "city": "Abuja", "district": "", "zip": "EC1N", "lat": 9.0579, "lon": 7.49508, "timezone": "Europe/London", "isp": "Airtel Networks Limited", "org": "Uni Broadband LLC", "as": "AS36873 NB NETWORKS GROUP LLC", "mobile": false, "proxy": false, "hosting": false, "query": "105.112.225.132", "region_name": "Abuja Federal Capital Territory"}, "device_info": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36", "user_id": "2", "reference": "2_815a0de4-bb6e-4e6e-a6fe-a1a75fee1366"}, "data": {"index": {"data": {}, "message": "Successfully continued to the main checks.", "status": true}, "countries": {"data": {"country": "Nigeria"}, "message": "Successfully continued to the next step.", "status": false}, "government_data": {"data": {"bvn": {"entity": {"customer": "c971fa6b-c478-4704-a864-2a41184f57f6", "app_id": "692f126a373b50511586047b", "bvn": "22372461261", "first_name": "SOMTOCHUKWU", "last_name": "OKAGBA", "middle_name": "ANTHONY", "gender": "Male", "date_of_birth": "1999-09-17", "phone_number1": "09082388267", "phone_number2": null, "image_url": "https://images.dojah.io/bvn_22372461261_1765881656.jpg", "email": null, "enrollment_bank": null, "enrollment_branch": null, "level_of_account": null, "lga_of_origin": null, "lga_of_residence": null, "marital_status": null, "name_on_card": null, "nationality": null, "nin": null, "registration_date": null, "residential_address": null, "state_of_origin": null, "state_of_residence": null, "title": null, "type": "basic", "xc": "c", "sc": true, "watch_listed": null, "createdAt": "2025-12-16T10:40:57.000Z", "updatedAt": "2025-12-16T10:40:57.000Z"}}}, "message": "", "status": false}, "id": {"data": {"id_url": "https://images.dojah.io/image_69411b65dd252200496018a3id_1765874917.jpg", "back_url": "https://images.dojah.io/image_69411b65dd252200496018a3backimage_1765874918.jpg", "id_data": {"first_name": "", "last_name": "", "middle_name": "", "nationality": "", "mrz_status": "", "expiry_date": "", "document_type": "", "document_number": "", "date_of_birth": "", "date_issued": "", "extras": ""}}, "status": false, "message": "Id Verification Failed"}, "selfie": {"data": {"selfie_url": "https://images.dojah.io/image_69411b65dd252200496018a3face_1765875096.jpg", "liveness_score": 0.0, "match_score": null}, "message": "Liveness Validaton Failed", "status": false}, "email": {"data": {"email": "michealbohz@gmail.com"}, "status": false, "message": "email collected successfully"}}, "id_type": "BVN", "value": "22372461261", "id_url": "https://images.dojah.io/image_69411b65dd252200496018a3id_1765874917.jpg", "back_url": "https://images.dojah.io/image_69411b65dd252200496018a3backimage_1765874918.jpg", "message": "The ID uploaded is not clear enough", "reference_id": "DJ-C082D0DF54", "widget_id": "692f14a877a4526a1608b60c", "verification_mode": "LIVENESS", "verification_type": "DL_ID", "verification_value": "", "verification_url": "https://app.dojah.io/verifications/bio-data/00bb51d7-2705-4539-ab9a-1fa3d8c9a334", "selfie_url": "https://images.dojah.io/image_69411b65dd252200496018a3face_1765875096.jpg", "status": false, "aml": {"status": false}, "verification_status": "Failed"}');
        // Log::info('DOJAH Webhook Received', $request->all());
        return $request->all();
        // // $reference = $request->input('reference');

        // dd($data);
        $data = $request->all();

        $user = User::where('kyc_reference', $data['metadata']['reference'] ?? null)->first();

        if ($user) {
            $user->update([
                'kyc_status'   => $data['status'] ?? 'failed',
                'kyc_response' => json_encode($data),
            ]);
        }

        return response()->json(['success' => true]);
    }



    public function payment_user(Request $request)
{
    $user = Auth::user();

    // Base query for user's payments (excluding service_charge)
    $query = Payment::where('user_id', $user->id)
                    ->where('package', '!=', 'service_charge');

    // 🔍 Search term (reference or package)
    if ($request->filled('search')) {
        $term = $request->search;
        $query->where(function ($q) use ($term) {
            $q->where('reference', 'like', "%{$term}%")
              ->orWhere('package', 'like', "%{$term}%");
        });
    }

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter by gateway
    if ($request->filled('gateway')) {
        $query->where('gateway', $request->gateway);
    }

    // Filter by date range
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    // Filter by amount
    if ($request->filled('amount_min')) {
        $query->where('amount', '>=', $request->amount_min);
    }

    if ($request->filled('amount_max')) {
        $query->where('amount', '<=', $request->amount_max);
    }

    // Get payments with pagination
    $payments = $query->orderBy('created_at', 'desc')->paginate(20);

    // Calculate statistics (also excluding service_charge)
    $allUserPayments = Payment::where('user_id', $user->id)
                              ->where('package', '!=', 'service_charge');

    $totalAmount = $allUserPayments->where('status', 'success')->sum('amount');
    $totalPayments = $allUserPayments->count();
    $successfulPayments = $allUserPayments->where('status', 'success')->count();

    return view('user_new.transaction', compact(
        'payments',
        'totalAmount',
        'totalPayments',
        'successfulPayments'
    ));
}



    public function generateVirtualAccountForUser($email, $firstName, $lastName, $phone, $bank = "wema-bank")
    {
        // Step 1: Create customer (if already exists, Paystack will return it)
        $customerResponse = $this->makeRequest("POST", $this->baseUrl . "/customer", [
            "email" => $email,
            "first_name" => $firstName,
            "last_name" => $lastName,
            "phone" => $phone
        ]);
        if (!$customerResponse['status']) {
            return [
                "status" => false,
                "message" => "Failed to create/fetch customer on Paystack",
                "error" => $customerResponse
            ];
        }

        $customerId = $customerResponse['data']['id']; // numeric ID

        // Step 2: Create dedicated account
        $accountResponse = $this->makeRequest("POST", $this->baseUrl . "/dedicated_account", [
            "customer" => $customerId,
            "preferred_bank" => 'test-bank'
        ]);
        return $accountResponse;
    }

    private function makeRequest($method, $url, $data = [])
    {
        $client = new \GuzzleHttp\Client();

        $options = [
            "headers" => [
                "Authorization" => "Bearer " . env('PAYSTACK_SECRET_KEY'),
                "Accept" => "application/json"
            ]
        ];

        if (!empty($data)) {
            $options["json"] = $data;
        }

        $response = $client->request($method, $url, $options);

        return json_decode($response->getBody(), true);
    }

    public function fincra($email, $firstName, $lastName, $phone, $bvn = null, $bank = "wema")
    {
        try {
            $payload = [
                "accountType" => "individual",
                "currency" => "NGN",
                "channel" => $bank,
                "KYCInformation" => [
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "email" => $email,
                ],
            ];

            // BVN is still valid and required for NGN accounts
            if ($bvn) {
                $payload["KYCInformation"]["bvn"] = $bvn;
            }

            \Log::info('Fincra Request Payload:', $payload);

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'api-key' => env('FINCRA_SECRET_KEY'),
                'x-business-id' => env('FINCRA_BUSINESS_ID'),
                'x-pub-key' => env('FINCRA_PUBLIC_KEY'),
                'content-type' => 'application/json'
            ])->post($this->get_base_url() . '/profile/virtual-accounts/requests', $payload);

            $data = $response->json();

            \Log::info('Fincra Response:', [
                'status_code' => $response->status(),
                'body' => $data,
            ]);

            if (!$response->successful() || empty($data['success'])) {
                return [
                    "status" => false,
                    "message" => $data['message'] ?? "Failed to create virtual account",
                    "response" => $data
                ];
            }

            $accountData = $data['data']['accountInformation'] ?? [];

            return [
                "status" => true,
                "data" => [
                    "account_name"   => $accountData['accountName'] ?? null,
                    "account_number" => $accountData['accountNumber'] ?? null,
                    "bank"           => $accountData['bankName'] ?? null,
                ]
            ];
        } catch (\Exception $e) {
            \Log::error('Fincra Exception:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }



    public function generate_virtual_account()
    {
        $email = Auth::user()->email;
        $first_name = Auth::user()->first_name;
        $last_name = Auth::user()->last_name;
        $phone = Auth::user()->phone;
        $bvn = Auth::user()->bvn ?? '22222222222';

        $account = $this->fincra($email, $first_name, $last_name, $phone, $bvn);

        if (!empty($account['status']) && $account['status'] === true) {
            $user = User::findOrFail(Auth::id());

            // save only account_name + account_number + bank name as JSON
            $user->virtual_account_number = json_encode([
                'account_name'   => $account['data']['account_name'] ?? null,
                'account_number' => $account['data']['account_number'] ?? null,
                'bank'           => $account['data']['bank'] ?? null,
            ]);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Account generated successfully',
                'data' => $user->virtual_account_number
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => $account['message'] ?? 'Failed to generate account'
        ]);
    }


    public function onboarding_page()
    {
        $states = OperationalState::all(); // Already saved states

        return view('user_new.onboarding', compact('states'));
    }





    public function pay_repayment(Request $request, $id)
    {
        $data = $request->all();   // grab all input from fetch()

        $gateway = $data['gateway'];
        $user = Auth::user();
        $repayment = LoanRepayment::findOrFail($id);
        $amount = $repayment->repayment_amount ?? 5000000;
        $reference = strtoupper($gateway) . '_' . Str::uuid();

        if ($gateway === 'wallet') {
            if (Auth::user()->wallet_balance <= $amount) {
                $availableBalance = number_format(Auth::user()->wallet_balance, 2);
                return GeneralController::sendNotification('', 'error', '', "Insufficient balance in your Aurelius Wallet. Your current balance is ₦" . $availableBalance . " Kindly fund your wallet or try another payment option. Thank you.");
            }
            $user->decrement('wallet_balance', $amount);
            $user->decrement('loan_balance', $amount);

            $repayment->status = 'paid';
            $repayment->save();

            DB::table('payments')->insert([
                'user_id'    => $user->id,
                'package'    => 'Outstanding Repayment|' . $id,
                'reference'  => $reference,
                'amount'     => $amount,
                'status'     => 'success',
                'gateway'    => $gateway,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $repayment->status = 'paid';
            $repayment->save();

            try {
                $primaryEmail = $user->email ?? null;
                $altEmail = $user->alt_email ?? null;

                // Filter valid emails
                $emails = array_filter([$primaryEmail, $altEmail]);

                if (!empty($emails)) {
                    $html = "
                    <h2>Hello {$user->first_name} {$user->last_name},</h2>
                    <p>Your Outstanding repayment of <strong>₦" . number_format($repayment->repayment_amount, 2) . "</strong> has been successfully processed.</p>
                    <p>Thank you for staying consistent with your payments.</p>
                ";

                    app(\App\Http\Controllers\LoanReminderController::class)
                        ->sendEmail($emails, "Outstanding Payment Successful", $html);
                }
            } catch (\Throwable $e) {
            }

            return GeneralController::sendNotification('', 'success', '', "Payment has been successfully deducted from your Aurelius Wallet");
        } else {
            DB::table('payments')->insert([
                'user_id'    => $user->id,
                'package'    => 'Outstanding Repayment|' . $id,
                'reference'  => $reference,
                'amount'     => $amount,
                'status'     => 'pending',
                'gateway'    => $gateway,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $paymentResponse = ($gateway === 'paystack')
            ? $this->createPaystackPayment($user, $amount, $reference)
            : $this->createFincraPayment($user, $amount, $reference);

        if (empty($paymentResponse['url'])) {
            return GeneralController::sendNotification('', 'error', '', "Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance");
        }

        return redirect()->away($paymentResponse['url']);
    }
    public function total_repayment(Request $request)
    {
        $data = $request->all();   // grab all input from fetch()

        $gateway = $data['gateway'];
        $user = Auth::user();
        $amount = $user->loan_balance ?? 5000000;
        $reference = strtoupper($gateway) . '_' . Str::uuid();

        if ($gateway === 'wallet') {
            if (Auth::user()->wallet_balance <= $amount) {
                $availableBalance = number_format(Auth::user()->wallet_balance, 2);
                return GeneralController::sendNotification('', 'error', '', "Insufficient balance in your Aurelius Wallet. Your current balance is ₦" . $availableBalance . " Kindly fund your wallet or try another payment option. Thank you.");
            }
            $user->decrement('wallet_balance', $amount);
            $user->decrement('loan_balance', $amount);

            LoanRepayment::where('user_id', $user->id)->update(['status' => 'paid']);

            DB::table('payments')->insert([
                'user_id'    => $user->id,
                'package'    => 'Outstanding Repayment',
                'reference'  => $reference,
                'amount'     => $amount,
                'status'     => 'success',
                'gateway'    => $gateway,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            try {
                $primaryEmail = $user->email ?? null;
                $altEmail = $user->alt_email ?? null;

                // Filter valid emails
                $emails = array_filter([$primaryEmail, $altEmail]);

                if (!empty($emails)) {
                    $html = "
                    <h2>Hello {$user->first_name} {$user->last_name},</h2>
                    <p>Your Outstanding repayment of <strong>₦" . number_format($amount, 2) . "</strong> has been successfully processed.</p>
                    <p>Thank you for staying consistent with your payments.</p>
                ";

                    app(\App\Http\Controllers\LoanReminderController::class)
                        ->sendEmail($emails, "Outstanding Payment Successful", $html);
                }
            } catch (\Throwable $e) {
            }

            return GeneralController::sendNotification('', 'success', '', "Payment has been successfully deducted from your Aurelius Wallet");
        } else {
            DB::table('payments')->insert([
                'user_id'    => $user->id,
                'package'    => 'Outstanding Repayment|all',
                'reference'  => $reference,
                'amount'     => $amount,
                'status'     => 'pending',
                'gateway'    => $gateway,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $paymentResponse = ($gateway === 'paystack')
            ? $this->createPaystackPayment($user, $amount, $reference)
            : $this->createFincraPayment($user, $amount, $reference);

        if (empty($paymentResponse['url'])) {
            return GeneralController::sendNotification('', 'error', '', "Payment Service is Down, Kindly Try Again Later or Reach out to Admin for Assistance");
        }

        return redirect()->away($paymentResponse['url']);
    }
}
