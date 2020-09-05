<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactImported
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \Illuminate\Database\Eloquent\Collection */
    public $contacts;

    /** @var \App\Campaign */
    public $campaign;

    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Database\Eloquent\Collection $contacts
     * @param \App\Campaign
     * @return void
     */
    public function __construct($contacts, $campaign)
    {
        $this->contacts = $contacts;
        $this->campaign = $campaign;
    }
}
