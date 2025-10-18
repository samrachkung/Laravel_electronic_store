<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function register()
    {
        return view('frontend.register.register');
    }

    public function sendOTP(Request $request)
    {
        try {
            \Log::info('Send OTP request received', $request->all());

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ]);

            $email = $request->email;
            $otp = $this->otpService->generateOTP($email, 'registration');

            \Log::info('OTP generated: ' . $otp);

            // Try to send email
            $emailSent = $this->otpService->sendOTP($email, $otp, 'registration');

            Session::put('registration_email', $email);
            Session::put('registration_data', $request->only(['name', 'password']));

            // Always return OTP for debugging
            $response = [
                'success' => true,
                'message' => $emailSent ? 'OTP sent to your email!' : 'OTP generated but email failed. OTP displayed below.',
                'show_otp' => true,
                'otp' => $otp // Always return OTP for testing
            ];

            if (!$emailSent) {
                \Log::warning("Email failed for {$email}, but OTP is: {$otp}");
            }

            return response()->json($response);

        } catch (\Exception $e) {
            \Log::error('Send OTP Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function verifyOTP(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|digits:6'
            ]);

            $email = Session::get('registration_email');
            $registrationData = Session::get('registration_data');

            if (!$email || !$registrationData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please try again.'
                ]);
            }

            if ($this->otpService->verifyOTP($email, $request->otp, 'registration')) {
                // Create user
                $user = User::create([
                    'name' => $registrationData['name'],
                    'email' => $email,
                    'password' => Hash::make($registrationData['password']),
                    'email_verified_at' => now(),
                ]);

                // Clear session
                Session::forget(['registration_email', 'registration_data']);

                // Auto-login the user
                Auth::login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP code.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Verify OTP Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $email = Session::get('registration_email');

            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please try again.'
                ]);
            }

            $otp = $this->otpService->generateOTP($email, 'registration');

            if ($this->otpService->sendOTP($email, $otp, 'registration')) {
                return response()->json([
                    'success' => true,
                    'message' => 'OTP resent to your email!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to resend OTP. Please try again.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Resend OTP Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
