<?php

return [
    'bakong_account_id' => env('KHQR_BAKONG_ACCOUNT_ID'),
    'merchant_name' => env('KHQR_MERCHANT_NAME'),
    'merchant_city' => env('KHQR_MERCHANT_CITY'),
    'merchant_id' => env('KHQR_MERCHANT_ID'),
    'acquiring_bank' => env('KHQR_ACQUIRING_BANK'),
    'mobile_number' => env('KHQR_MOBILE_NUMBER'),
    'api_token' => env('KHQR_API_TOKEN'),
    'api_url' => env('KHQR_API_URL', 'https://api-bakong.nbc.gov.kh'),
    'qr_expiry_minutes' => env('KHQR_QR_EXPIRY_MINUTES', 10),
    'check_interval_seconds' => env('KHQR_CHECK_INTERVAL_SECONDS', 3),
    'verify_ssl' => env('KHQR_VERIFY_SSL', true), // Add this
];
