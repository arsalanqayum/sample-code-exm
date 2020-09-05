<?php

namespace App\Events\Campaign;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactDetached
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var array */
    public $ids;

    /** @var int|string */
    public $campaign_id;

    /**
     * Create a new event instance.
     *
     * @param array
     * @param int|string
     * @return void
     */
    public function __construct($ids, $campaign_id)
    {
        $this->ids = $ids;
        $this->campaign_id = $campaign_id;
    }
}
