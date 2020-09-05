<?php

namespace App\Traits\Stripe;

use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent as StripePaymentIntent;

trait PaymentIntent
{
    /**
     * Create payment intent
     *
     * @param array $data
     * @return mixed|null
     */
    public function createPaymentIntent($data)
    {
        $user = auth()->user();

        try {
            $intent = StripePaymentIntent::create([
                'amount' => $data['amount'] * 100,
                'currency' => 'usd',
                'metadata' => [
                    'company_id' => $user->company->id,
                ],
            ]);

            return $intent;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            return null;
        }
    }

    /**
     * Retrieve payment intent
     *
     * @param array $data
     * @return mixed|null
     */
    public function showPaymentIntent($data)
    {
        try {
            $intent = StripePaymentIntent::retrieve(
                $data['id'],
                [
                    $data['client_secret']
                ],
            );

            return $intent;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            return null;
        }
    }
}