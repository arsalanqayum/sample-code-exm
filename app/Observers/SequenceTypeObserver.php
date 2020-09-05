<?php

namespace App\Observers;

use App\SequenceType;
use Illuminate\Support\Facades\Log;

class SequenceTypeObserver
{
    /**
     * Handle the sequence type "created" event.
     *
     * @param  \App\SequenceType  $sequenceType
     * @return void
     */
    public function created(SequenceType $sequenceType)
    {
        foreach ($sequenceType->campaign->contacts as $contact) {
            $sequenceType->recipients()->create([
                'contact_id' => $contact->id
            ]);
        }
    }

    /**
     * Handle the sequence type "updated" event.
     *
     * @param  \App\SequenceType  $sequenceType
     * @return void
     */
    public function updated(SequenceType $sequenceType)
    {
        //
    }

    /**
     * Handle the sequence type "deleted" event.
     *
     * @param  \App\SequenceType  $sequenceType
     * @return void
     */
    public function deleted(SequenceType $sequenceType)
    {
        $sequenceType->recipients()->delete();
    }

    /**
     * Handle the sequence type "restored" event.
     *
     * @param  \App\SequenceType  $sequenceType
     * @return void
     */
    public function restored(SequenceType $sequenceType)
    {
        //
    }

    /**
     * Handle the sequence type "force deleted" event.
     *
     * @param  \App\SequenceType  $sequenceType
     * @return void
     */
    public function forceDeleted(SequenceType $sequenceType)
    {
        //
    }
}
