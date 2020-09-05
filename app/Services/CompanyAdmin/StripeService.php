<?php

namespace App\Services\CompanyAdmin;

use App\StripeAccount;
use App\Traits\Stripe\Account;

class StripeService
{
    use Account;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * create stripe account
     *
     * @param $data
     * @return void
     */
    public function createStripeAccount($data)
    {
        $stripeAccount = new StripeAccount();
        $stripeAccount->user_id = auth()->id();
        $stripeAccount->account_id = $data['id'];
        $stripeAccount->save();
    }
}