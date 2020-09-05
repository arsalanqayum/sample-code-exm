<?php

namespace App\Observers;

use App\CampaignAccount;
use App\Contact;
use App\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //Check if user type is owner
        if($user->type == User::OWNER) {
            //Connect to campaign account if contact is found
            $contact = Contact::where([
                'status' => 'campaign',
                'email' => $user->email,
            ])->first();

            if($contact && $contact->campaign_id) {
                $ca = new CampaignAccount();
                $ca->user_id = $user->id;
                $ca->campaign_id = $contact->campaign_id;
                $ca->save();
            }
        }
    }
}
