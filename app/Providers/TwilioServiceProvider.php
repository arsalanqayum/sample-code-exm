<?php

namespace App\Providers;

use App\Facades\Twilio\Twilio;
use Illuminate\Support\ServiceProvider;

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Twilio::class, function($app) {
            return new Twilio(config('sms.twilio.sid'),config('sms.twilio.secret'));
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
