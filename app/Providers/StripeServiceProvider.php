<?php

namespace App\Providers;

use App\Facades\Stripe\Stripe;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Stripe::class, function($app) {
            return new Stripe(config('services.stripe.secret'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
