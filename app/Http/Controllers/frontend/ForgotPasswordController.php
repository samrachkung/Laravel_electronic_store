<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function showForgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    public function sendPasswordResetOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $email = $request->email;
            $otp = $this->otpService->generateOTP($email, 'password_reset');

            if ($this->otpService->sendOTP($email, $otp, 'password_reset')) {
                Session::put('password_reset_email', $email);

                return response()->json([
                    'success' => true,
                    'message' => 'OTP sent to your email!',
                    'show_otp' => true
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);

        } catch (\Exception $e) {
            \Log::error('Send Password Reset OTP Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyPasswordResetOTP(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|digits:6'
            ]);

            $email = Session::get('password_reset_email');

            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please try again.'
                ]);
            }

            if ($this->otpService->verifyOTP($email, $request->otp, 'password_reset')) {
                Session::put('otp_verified', true);

                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified!',
                    'show_password_form' => true
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP code.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Verify Password Reset OTP Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|min:6|confirmed',
            ]);

            $email = Session::get('password_reset_email');
            $otpVerified = Session::get('otp_verified');

            if (!$email || !$otpVerified) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please try again.'
                ]);
            }

            $user = User::where('email', $email)->first();

            if ($user) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);

                // Clear session
                Session::forget(['password_reset_email', 'otp_verified']);

                // Auto-login the user
                Auth::login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Password reset successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Reset Password Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resendPasswordResetOTP(Request $request)
    {
        try {
            $email = Session::get('password_reset_email');

            if (!$email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please try again.'
                ]);
            }

            $otp = $this->otpService->generateOTP($email, 'password_reset');

            if ($this->otpService->sendOTP($email, $otp, 'password_reset')) {
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
            \Log::error('Resend Password Reset OTP Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
