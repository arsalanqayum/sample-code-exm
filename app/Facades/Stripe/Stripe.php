<?php

namespace App\Facades\Stripe;

use App\PaymentHistory;
use App\Traits\Stripe\Account;
use App\Traits\Stripe\Person;
use App\StripeAccount;
use App\Traits\Stripe\Balance;
use App\Traits\Stripe\Charge;
use App\Traits\Stripe\PaymentIntent;
use App\Traits\Stripe\Payout;
use App\Traits\Stripe\Transfer;

class Stripe
{
    use Account, Person, Charge, PaymentIntent, Balance, Transfer, Payout;

    /** @var string */
    public $secret_key;

    /**
     * Constructor
     *
     * @param string $secret_key
     * @return void
     */
    public function __construct($secret_key)
    {
        $this->secret_key = $secret_key;

        \Stripe\Stripe::setApiKey($this->secret_key);
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

    /**
     * Create company charge payment history
     *
     * @param array $intent
     * @return void
     */
    public function createChargeHistory($intent)
    {
        $company = auth()->user()->company;

        $company->paymentHistories()->create([
            'uniqid' => $intent['id'],
            'amount' => $intent['amount'],
            'type' => PaymentHistory::CHARGE,
            'status' => $intent['status'],
        ]);
    }
}