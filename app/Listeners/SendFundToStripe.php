<?php

namespace App\Listeners;

use App\Events\PaymentTransfered;
use App\Facades\Stripe;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFundToStripe implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PaymentTransfered $event
     * @return void
     */
    public function handle(PaymentTransfered $event)
    {
        $user = $event->user;

        if($user->stripeAccount) {
            $transfer = Stripe::createTransfer([
                'account_id' => $user->stripeAccount->account_id,
                'amount' => $event->amount
            ]);

            if($transfer) {
                $user->withdraw($event->amount, ['type' => 'dont_track']);
            }
        }
    }
}
