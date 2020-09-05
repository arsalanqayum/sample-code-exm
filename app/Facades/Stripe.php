<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static void createStripeAccount(array $data)
 * @method static mixed|null createExternalAccount(array $data)
 * @method static mixed|null createPayout(array $data)
 * @method static object|null retrieve(string $account_id)
 * @method static mixed|null createTransfer(array data, array $metadata)
 */
class Stripe extends Facade
{
    /** @return string */
    protected static function getFacadeAccessor()
    {
        return 'App\Facades\Stripe\Stripe';
    }
}