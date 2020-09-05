<?php

namespace App\Traits\Stripe;

use Illuminate\Support\Facades\Log;
use Stripe\Charge as StripeCharge;

trait Charge
{
    /**
     * Charge bank account
     *
     * @param array $data
     * @return mixed|null
     */
    public function createCharge($data)
    {
        try {
            $charge = StripeCharge::create([
                'amount' => $data['amount'],
                'currency' => 'usd',
                'source' => $data['source'],
                'description' => 'Add Balance m',
            ]);

            return $charge;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            return null;
        }
    }
}