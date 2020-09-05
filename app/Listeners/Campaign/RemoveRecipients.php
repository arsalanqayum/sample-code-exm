<?php

namespace App\Listeners\Campaign;

use App\Campaign;
use App\Events\Campaign\ContactDetached;
use App\RecipientStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveRecipients
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ContactDetached $event
     * @return void
     */
    public function handle(ContactDetached $event)
    {
        $campaign = Campaign::find($event->campaign_id);

        if($campaign) {
            foreach ($campaign->sequence_types as $st) {
                RecipientStatus::where('sequence_type_id', $st->id)->whereIn('contact_id', $event->ids)->delete();
            }
        }
    }
}
