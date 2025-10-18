<?php

namespace App\Services;

use App\Models\OtpCode;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class OTPService
{
    public function generateOTP($email, $type)
    {
        try {
            // Check if table exists first
            if (!Schema::hasTable('otp_codes')) {
                Log::error('otp_codes table does not exist!');
                throw new \Exception('OTP table not found. Please run migrations.');
            }

            // Delete any existing OTPs for this email and type
            OtpCode::where('email', $email)
                ->where('type', $type)
                ->where('is_used', false)
                ->delete();

            // Generate 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Create OTP record
            OtpCode::create([
                'email' => $email,
                'otp' => $otp,
                'type' => $type,
                'expires_at' => now()->addMinutes(10),
            ]);

            Log::info("OTP generated for {$email}: {$otp}");

            return $otp;
        } catch (\Exception $e) {
            Log::error('Error generating OTP: ' . $e->getMessage());
            throw $e;
        }
    }

    public function sendOTP($email, $otp, $type)
    {
        try {
            Log::info("Attempting to send OTP to {$email} using Gmail SMTP");

            // Send email using Gmail SMTP
            Mail::to($email)->send(new OTPMail($otp, $type));

            Log::info("OTP email sent successfully to {$email}");
            return true;

        } catch (\Exception $e) {
            Log::error('Gmail OTP sending failed: ' . $e->getMessage());
            Log::error('Error details: ' . $e->getFile() . ':' . $e->getLine());

            // Log the OTP for manual testing
            Log::info("MANUAL OTP for {$email}: {$otp}");

            return false;
        }
    }

    // ... rest of your methods remain the same
    public function verifyOTP($email, $otp, $type)
    {
        try {
            $otpRecord = OtpCode::where('email', $email)
                ->where('type', $type)
                ->where('otp', $otp)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->first();

            if ($otpRecord) {
                $otpRecord->update(['is_used' => true]);
                Log::info("OTP verified successfully for {$email}");
                return true;
            }

            Log::warning("Invalid OTP attempt for {$email}");
            return false;
        } catch (\Exception $e) {
            Log::error('Error verifying OTP: ' . $e->getMessage());
            return false;
        }
    }

    public function hasValidOTP($email, $type)
    {
        return OtpCode::where('email', $email)
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
