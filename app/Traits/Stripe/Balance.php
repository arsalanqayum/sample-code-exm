<?php

namespace App\Traits\Stripe;

use Illuminate\Support\Facades\Log;
use Stripe\Balance as StripeBalance;

trait Balance
{
    /**
     * Retrieve auth user connected account balance
     *
     * @return mixed|null
     */
    public function retrieveBalance()
    {
        try {
            $balance = StripeBalance::retrieve([
                'stripe_account' => auth()->user()->stripeAccount->account_id,
            ]);

            return $balance;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            return null;
        }
    }
}