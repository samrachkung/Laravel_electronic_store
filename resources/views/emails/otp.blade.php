<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4F46E5; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .otp-code {
            background: white;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 10px;
            border-radius: 8px;
            border: 2px dashed #4F46E5;
        }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>OTP Verification</h1>
        </div>

        <div class="content">
            <p>Hello,</p>

            @if($type === 'registration')
            <p>Thank you for registering! Use the OTP code below to verify your email address:</p>
            @else
            <p>Use the OTP code below to reset your password:</p>
            @endif

            <div class="otp-code">
                {{ $otp }}
            </div>

            <p>This OTP code will expire in 10 minutes.</p>
            <p>If you didn't request this code, please ignore this email.</p>

            <p>Best regards,<br>{{ config('app.name') }} Team</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
