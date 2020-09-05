<?php

namespace App\Listeners\Campaign;

use App\Events\Campaign\ContactImported;
use App\RecipientStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddRecipients
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
     * @param  object  $event
     * @return void
     */
    public function handle(ContactImported $event)
    {
        foreach($event->campaign->sequence_types as $st) {
            foreach ($event->contacts as $contact) {
                $rs = new RecipientStatus();
                $rs->forceFill([
                    'contact_id' => $contact->id,
                    'sequence_type_id' => $st->id
                ])->save();
            }
        }
    }
}
