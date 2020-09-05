<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentTransfered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\User */
    public $user;

    /** @var string|int */
    public $amount;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user
     * @param string|int $amount
     * @return void
     */
    public function __construct($user, $amount)
    {
        $this->user = $user;
        $this->amount = $amount;
    }
}
