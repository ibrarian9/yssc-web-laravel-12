<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request, MidtransService $midtrans)
    {
        $notification = $request->all();

        Log::info('Midtrans notification received', $notification);

        // Verify signature
        if (!$midtrans->verifySignature($notification)) {
            Log::warning('Midtrans invalid signature', $notification);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderId = $notification['order_id'] ?? null;
        $transactionStatus = $notification['transaction_status'] ?? null;
        $paymentType = $notification['payment_type'] ?? null;
        $fraudStatus = $notification['fraud_status'] ?? null;

        $donasi = Donasi::where('midtrans_order_id', $orderId)->first();

        if (!$donasi) {
            Log::warning('Midtrans: donation not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Map Midtrans status → our status
        $newStatus = match ($transactionStatus) {
            'capture' => ($fraudStatus === 'accept' ? 'success' : 'pending'),
            'settlement' => 'success',
            'pending' => 'pending',
            'deny', 'cancel' => 'failed',
            'expire' => 'expired',
            'refund', 'partial_refund' => 'refunded',
            default => $donasi->status_pembayaran,
        };

        $updateData = [
            'status_pembayaran' => $newStatus,
            'midtrans_payment_type' => $paymentType,
        ];

        if ($newStatus === 'success' && !$donasi->paid_at) {
            $updateData['paid_at'] = now();
        }

        $donasi->update($updateData);

        Log::info('Midtrans donation updated', [
            'order_id' => $orderId,
            'status' => $newStatus,
            'donasi_id' => $donasi->id,
        ]);

        return response()->json(['message' => 'OK']);
    }
}
