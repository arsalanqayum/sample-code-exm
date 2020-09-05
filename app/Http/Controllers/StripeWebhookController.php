<?php

namespace App\Http\Controllers;

use App\Traits\Stripe\Webhook\Payout;
use Laravel\Cashier\Http\Controllers\WebhookController;

class StripeWebhookController extends WebhookController
{
    use Payout;
}
