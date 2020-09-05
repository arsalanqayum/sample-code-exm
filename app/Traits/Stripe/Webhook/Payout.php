<?php

namespace App\Traits\Stripe\Webhook;

use App\User;

trait Payout
{
    /**
     * Handle payout.created
     *
     * @param mixed $payload
     * @return void
     */
    public function handlePayoutCreated($payload)
    {
        $this->updateOrCreatePayout($payload);
    }

    /**
     * Handle payout updated
     *
     * @param mixed $payload
     * @return void
     */
    public function handlePayoutUpdated($payload)
    {
        $this->updateOrCreatePayout($payload);
    }

    /**
     * Handle payout.failed
     *
     * @param mixed $payload
     * @return void
     */
    public function handlePayoutFailed($payload)
    {
        $this->updateOrCreatePayout($payload);
    }

    /**
     * Handle payout paid
     *
     * @param mixed $payload
     * @return void
     */
    public function handlePayoutPaid($payload)
    {
        $this->updateOrCreatePayout($payload);
    }

    /**
     * Handle payout canceled
     *
     * @param mixed $payload
     * @return void
     */
    public function handlePayoutCanceled($payload)
    {
        $this->updateOrCreatePayout($payload);
    }

    /**
     * For all payout webhook
     *
     * @param array $payload
     * @return void
     */
    public function updateOrCreatePayout($payload)
    {
        $data = $payload['data']['object'];

        //Check if payout metadata has user id key value
        //then create payment histories
        if(count($data['metadata']) && isset($data['metadata']['user_id'])) {

            if($user = User::find($data['metadata']['user_id'])) {
                $user->paymentHistories()->updateOrCreate(
                    ['uniqid' => $data['id'] ],
                    [
                        'amount' => $data['amount'],
                        'type' => 'payout',
                        'status' => $data['status'],
                        'description' => 'Owner Payout'
                    ]
                );
            }
        }
    }
}