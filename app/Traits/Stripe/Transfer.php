<?php

namespace App\Traits\Stripe;

use Illuminate\Support\Facades\Log;
use Stripe\Transfer as StripeTransfer;

trait Transfer
{
    /**
     * Create transfer
     *
     * @param array $data
     * @return mixed|null
     */
    public function createTransfer($data, $metadata = [])
    {
        try {
            $transfer = StripeTransfer::create([
                'amount' => $data['amount'],
                'currency' => 'usd',
                'destination' => $data['account_id'],
                'metadata' => $metadata
            ]);

            return $transfer;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            return null;
        }
    }
}