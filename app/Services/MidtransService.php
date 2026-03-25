<?php

namespace App\Services;

use App\Models\Donasi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    private string $serverKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->baseUrl = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    /**
     * Create a Snap token for a donation transaction.
     */
    public function createSnapToken(Donasi $donasi): ?string
    {
        $orderId = 'YSSC-' . $donasi->id . '-' . time();

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $donasi->nominal,
            ],
            'customer_details' => [
                'first_name' => $donasi->nama_donatur,
                'email' => $donasi->email_donatur,
                'phone' => $donasi->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'DONASI-' . $donasi->program_donasi_id,
                    'price' => (int) $donasi->nominal,
                    'quantity' => 1,
                    'name' => 'Donasi: ' . substr($donasi->program->judul ?? 'Program', 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => url('/donasi/' . ($donasi->program->slug ?? '')),
            ],
        ];

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->acceptJson()
                ->post($this->baseUrl . '/transactions', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $snapToken = $data['token'] ?? null;

                // Save order ID and snap token on the donation
                $donasi->update([
                    'midtrans_order_id' => $orderId,
                    'midtrans_snap_token' => $snapToken,
                ]);

                return $snapToken;
            }

            Log::error('Midtrans Snap API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'donasi_id' => $donasi->id,
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Midtrans Snap exception', [
                'message' => $e->getMessage(),
                'donasi_id' => $donasi->id,
            ]);
            return null;
        }
    }

    /**
     * Verify the signature from Midtrans notification.
     */
    public function verifySignature(array $notification): bool
    {
        $orderId = $notification['order_id'] ?? '';
        $statusCode = $notification['status_code'] ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';
        $signatureKey = $notification['signature_key'] ?? '';

        $expectedSignature = hash('sha512',
            $orderId . $statusCode . $grossAmount . $this->serverKey
        );

        return $signatureKey === $expectedSignature;
    }
}
