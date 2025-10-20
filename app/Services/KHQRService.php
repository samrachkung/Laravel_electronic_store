<?php

namespace App\Services;

use KHQR\BakongKHQR;
use KHQR\Models\IndividualInfo;
use KHQR\Models\MerchantInfo;
use KHQR\Helpers\KHQRData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class KHQRService
{
    protected $bakongKhqr;

    public function __construct()
    {
        $token = config('khqr.api_token');
        $this->bakongKhqr = $token ? new BakongKHQR($token) : null;
    }

    /**
     * Generate KHQR for merchant payment
     */
    public function generateMerchantQR($amount, $currency = 'USD', $billNumber = null, $storeLabel = null)
    {
        try {
            $merchantInfo = new MerchantInfo(
                bakongAccountID: config('khqr.bakong_account_id'),
                merchantName: config('khqr.merchant_name'),
                merchantCity: config('khqr.merchant_city'),
                merchantID: config('khqr.merchant_id'),
                acquiringBank: config('khqr.acquiring_bank'),
                mobileNumber: config('khqr.mobile_number'),
                currency: $currency === 'USD' ? KHQRData::CURRENCY_USD : KHQRData::CURRENCY_KHR,
                amount: $amount,
                billNumber: $billNumber,
                storeLabel: $storeLabel
            );

            $response = BakongKHQR::generateMerchant($merchantInfo);

            if ($response->status['code'] === 0) {
                return [
                    'success' => true,
                    'qr' => $response->data['qr'],
                    'md5' => $response->data['md5'],
                ];
            }

            return [
                'success' => false,
                'error' => $response->status['message'] ?? 'Failed to generate KHQR'
            ];

        } catch (\Exception $e) {
            Log::error('KHQR Generation Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check transaction status by MD5
     */
    public function checkTransactionByMD5($md5Hash)
    {
        try {
            if (!$this->bakongKhqr) {
                return ['success' => false, 'error' => 'KHQR API token not configured'];
            }

            // For development: Use custom HTTP client with SSL handling
            if (app()->environment('local', 'development')) {
                return $this->checkTransactionWithCustomClient($md5Hash);
            }

            // Production: Use standard SDK method
            $response = $this->bakongKhqr->checkTransactionByMD5($md5Hash);

            Log::info('KHQR API Response (SDK)', [
                'md5' => $md5Hash,
                'response' => $response
            ]);

            return [
                'success' => true,
                'data' => $response
            ];

        } catch (\Exception $e) {
            Log::error('KHQR Transaction Check Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Custom transaction check with SSL options for development
     * According to Bakong API documentation
     */
    protected function checkTransactionWithCustomClient($md5Hash)
    {
        try {
            $apiUrl = config('khqr.api_url', 'https://api-bakong.nbc.gov.kh');
            $token = config('khqr.api_token');

            // Build HTTP client with conditional SSL verification
            $httpClient = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]);

            // Disable SSL verification only in local environment
            if (app()->environment('local', 'development')) {
                $httpClient = $httpClient->withoutVerifying();
            }

            // Correct API endpoint and payload format according to Bakong docs
            $response = $httpClient->post("{$apiUrl}/v1/check_transaction_by_md5", [
                'md5' => $md5Hash
            ]);

            Log::info('Custom KHQR API Call', [
                'url' => "{$apiUrl}/v1/check_transaction_by_md5",
                'payload' => ['md5' => $md5Hash],
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Convert to object for consistency with SDK
                $dataObject = json_decode(json_encode($data));

                return [
                    'success' => true,
                    'data' => $dataObject
                ];
            }

            return [
                'success' => false,
                'error' => 'Transaction check failed: ' . $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('Custom Transaction Check Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify KHQR code validity
     */
    public function verifyKHQR($qrCode)
    {
        try {
            $result = BakongKHQR::verify($qrCode);
            return [
                'success' => true,
                'valid' => $result->isValid
            ];
        } catch (\Exception $e) {
            Log::error('KHQR Verification Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Decode KHQR to get payment details
     */
    public function decodeKHQR($qrCode)
    {
        try {
            $result = BakongKHQR::decode($qrCode);

            if ($result->status['code'] === 0) {
                return [
                    'success' => true,
                    'data' => $result->data
                ];
            }

            return [
                'success' => false,
                'error' => $result->status['message'] ?? 'Failed to decode KHQR'
            ];

        } catch (\Exception $e) {
            Log::error('KHQR Decode Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
