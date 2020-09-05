<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'owner_send_chat' => [
            'App\Listeners\AddEarningToOwner'
        ],
        // Campaign
        'App\Events\Campaign\ContactImported' => [
            'App\Listeners\Campaign\AddRecipients',
        ],
        'App\Events\Campaign\ContactDetached' => [
            'App\Listeners\Campaign\RemoveRecipients',
        ],
        //Reward
        'App\Events\PaymentTransfered' => [
            'App\Listeners\SendFundToStripe'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
