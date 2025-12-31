<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ReferralController;
use App\Models\PlatformSetting;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;



class RegisteredUserController extends Controller
{
    
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $settings = PlatformSetting::first();

        return view('auth_new.register', compact('settings'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    /**
 * @group Authentication
 * Register a new user
 *
 * Creates a new user account.
 *
 * @bodyParam name string required The user's name.
 * @bodyParam email string required The user's email.
 * @bodyParam password string required The user's password.
 *
 * @response 201 {
 *  "success": true,
 *  "user": {
 *      "id": 1,
 *      "name": "John Doe",
 *      "email": "user@example.com"
 *  }
 * }
 */



    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
                'state' => ['required', 'string'],
                'lga' => ['required', 'string'],
                'country' => ['required', 'string'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'employee_status' => 'required',
                'student_id' => 'nullable|required_if:employee_status,Student|mimes:jpg,jpeg,png,pdf|max:2048',
                'school_name' => 'required_if:employee_status,Student|string|nullable|max:255',
                'referral_code' => 'nullable|string',
            ]);


            if (!is_null($request->referral_code)) {
                $validate_referral_code =   ReferralController::registerReferral($request->referral_code, NULL, true);
                if (!$validate_referral_code['success']) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $validate_referral_code['message'],
                    ], 404);
                }
            }
            // File upload
            $studentIdPath = null;
            if ($request->hasFile('student_id')) {
                $file = $request->file('student_id');
                $studentIdPath = 'uploads/student_ids/';
                if (!file_exists(public_path($studentIdPath))) {
                    mkdir(public_path($studentIdPath), 0755, true);
                }
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($studentIdPath), $filename);
                $studentIdPath .= $filename;
            }

            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'state' => $validated['state'],
                'lga' => $validated['lga'],
                'country' => $validated['country'],
                'employee_status' => $validated['employee_status'],
                'student_id' => $studentIdPath,
                'school_name' => $request->school_name,
                'password' => Hash::make($validated['password']),
            ]);

            event(new Registered($user));

            $otp = rand(100000, 999999);
            Cache::put('otp_' . $user->email, $otp, now()->addMinutes(10));

            try {
                Mail::html("
                    <html>
                    <body style='font-family: Arial, sans-serif; line-height:1.6; color:#333;'>
                        
                        <h2 style='margin-bottom:10px;'>Aurelius One-Time Password (OTP) Verification</h2>
            
                        <p>Hello,</p>
            
                        <p>To continue your registration on Aurelius, please use the One-Time Password (OTP) below:</p>
            
                        <p style='font-size:22px; font-weight:bold; margin:15px 0;'>🔐 Your OTP Code: {$otp}</p>
            
                        <p>This code will expire in 10 minutes for security reasons.</p>
            
                        <p>If you did not request this code, please ignore this message.</p>
            
                        <p>For support or inquiries, contact us at 
                            <a href='mailto:hello@aureliushq.co'>hello@aureliushq.co</a> 
                            or visit <a href='https://www.aureliushq.co'>www.aureliushq.co</a>.
                        </p>
            
                        <p>Thank you for choosing Aurelius<br>
                        <strong>Simplifying Food Access for Every Nigerian.</strong></p>
            
                        <hr style='margin:25px 0;'>
            
                        <p style='font-size:12px; color:#888;'>
                            <strong>Aurelius Nigeria (HQ)</strong><br>
                            Kenuj, O2 Mall, Kaura, Abuja<br>
                            | 020 1330 6342 | 0807 540 2989 | 
                            <a href='mailto:info@aureliushq.co'>info@aureliushq.co</a><br>
                            Website: <a href='https://www.aureliushq.co'>www.aureliushq.co</a>
                        </p>
            
                        <p style='font-size:12px; color:#888;'>Please do not reply to this email, this mailbox is not monitored.</p>
            
                    </body>
                    </html>
                ", function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Your Aurelius OTP Code');
                });
            } catch (\Throwable $e) {
                // Handle exception here if needed
            }
            
            if (!is_null($request->referral_code)) {
                ReferralController::registerReferral($request->referral_code, $user->id, false);
            }

            Auth::login($user);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'redirect' => route('otp.verify'),
                    'message' => 'Registration successful! Check your email for OTP.'
                ]);
            }

            return redirect()->route('otp.verify')->with('status', 'Registration successful! Check your email for OTP.');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong. Please try again.',
                ], 500);
            }
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function store_old(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'state' => ['required', 'string'],
            'lga' => ['required', 'string'],
            'country' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'employee_status' => 'required',
            'student_id' => 'nullable|required_if:employee_status,Student|mimes:jpg,jpeg,png,pdf|max:2048',
            'school_name' => 'required_if:employee_status,Student|string|nullable|max:255',

        ]);

        $studentIdPath = null;
        if ($request->hasFile('student_id')) {
            $file = $request->file('student_id');
            $studentIdPath = 'uploads/student_ids/';
            if (!file_exists(public_path($studentIdPath))) {
                mkdir(public_path($studentIdPath), 0755, true);
            }
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($studentIdPath), $filename);
            $studentIdPath .= $filename;
        }


        // ✅ Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'state' => $request->state,
            'lga' => $request->lga,
            'country' => $request->country,
            'employee_status' => $request->employee_status,
            'student_id' => $studentIdPath, // 👈 now it stores the file path
            'school_name' => $request->school_name,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Fire registered event
        event(new Registered($user));

        // ✅ Generate OTP and store in cache (valid for 10 minutes)
        $otp = rand(100000, 999999);
        Cache::put('otp_' . $user->email, $otp, now()->addMinutes(10));

        // ✅ Send OTP email directly here
        Mail::raw("Your Aurelius OTP Code is: {$otp}\n\nThis code expires in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Aurelius OTP Code');
        });

        // ✅ Login user
        Auth::login($user);

        return redirect()->route('otp.verify')->with('status', 'Registration successful! Check your email for OTP.');
    }

    public function getStates()
    {
        $response = Http::get('https://api.facts.ng/v1/states');
        $states = $response->json();

        // Append FCT in same format
        $states[] = [
            'id' => 'fct',   // this matches your frontend "value"
            'name' => 'Federal Capital Territory (Abuja)',
        ];

        return $states;
    }

    public function getLgas($state)
    {

        /**
         * @group Authentication
         * Get LGAs for a state
         *
         * Returns all local government areas for a given state.
         *
         * @urlParam state string required Name of the state.
         *
         * @response 200 {
         *  "state": "Lagos",
         *  "lgas": ["Ikeja", "Epe", "Surulere"]
         * }
         */
        $state = strtolower(trim($state));

        // Handle FCT manually
        if ($state === 'fct') {
            return [
                'lgas' => [
                    'Abaji',
                    'Abuja Municipal Area Council',
                    'Bwari',
                    'Gwagwalada',
                    'Kuje',
                    'Kwali'
                ]
            ];
        }

        // Default: fetch from API
        $state = urlencode($state);
        $response = Http::get("https://api.facts.ng/v1/states/{$state}");
        return $response->json();
    }
}
