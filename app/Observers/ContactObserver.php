<?php

namespace App\Observers;

use App\Contact;
use App\ContactList;

class ContactObserver
{
    /**
     * handle the contact "creating" event
     *
     * @param Contact $contact
     * @return void
     */
    public function creating(Contact $contact)
    {
        if(!$contact->contact_list_id) {
            $contact->contact_list_id = ContactList::where('company_id', company()->id)->first()->id;
        }

        if(request()->has('campaign_id')) {
            $contact->campaign_id = request('campaign_id');
            $contact->status = Contact::CAMPAIGN;
        }
    }
}
