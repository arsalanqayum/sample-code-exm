<?php

namespace App\Observers;

use App\Campaign;
use App\Contact;

class CampaignObserver
{
    /**
     * Handle the campaign "creating" event.
     *
     * @param  \App\Campaign  $campaign
     * @return void
     */
    public function created(Campaign $campaign)
    {
        $campaign->reward_value = $campaign->reward_value * 100;
        $campaign->save();
    }

    /**
     * Handle the campaign "updated" event.
     *
     * @param  \App\Campaign  $campaign
     * @return void
     */
    public function updated(Campaign $campaign)
    {
        //
    }

    /**
     * Handle the campaign "deleted" event.
     *
     * @param  \App\Campaign  $campaign
     * @return void
     */
    public function deleted(Campaign $campaign)
    {
        foreach($campaign->contacts as $contact) {
            $contact->forceFill([
                'campaign_id' => null,
                'status' => Contact::CONTACT,
            ])->save();
        }

        $campaign->sequence_types()->delete();
    }

    /**
     * Handle the campaign "restored" event.
     *
     * @param  \App\Campaign  $campaign
     * @return void
     */
    public function restored(Campaign $campaign)
    {
        //
    }

    /**
     * Handle the campaign "force deleted" event.
     *
     * @param  \App\Campaign  $campaign
     * @return void
     */
    public function forceDeleted(Campaign $campaign)
    {
        //
    }
}
