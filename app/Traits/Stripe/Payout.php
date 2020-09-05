<?php

namespace App\Traits\Stripe;

use App\Exceptions\StripeException;
use Exception;
use Stripe\Payout as StripePayout;

trait Payout
{
    /**
     * Create payout and send to owner
     *
     * @param array $data
     * @return mixed|null
     */
    public function createPayout($data)
    {
        $user = auth()->user();

        try {
            $payout = StripePayout::create([
                'amount' => $data['amount'] * 100,
                'currency' => 'usd',
                'description' => 'Owner Payout',
                'destination' => $data['bank_account'],
                'metadata' => [
                    'user_id' => auth()->id()
                ]
            ],['stripe_account' => $user->stripeAccount->account_id]);

            return $payout;
        } catch (\Throwable $th) {
            throw new StripeException($th);
        }
    }
}