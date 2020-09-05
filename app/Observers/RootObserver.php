<?php

namespace App\Observers;

use App\Campaign;
use App\Company;
use App\Contact;
use App\Product;
use App\SequenceType;
use App\User;

class RootObserver
{
    /**
     * Observer to inject
     *
     * @return void
     */
    public static function inject()
    {
        Contact::observe(ContactObserver::class);
        Product::observe(ProductObserver::class);
        Campaign::observe(CampaignObserver::class);
        Company::observe(CompanyObserver::class);
        SequenceType::observe(SequenceTypeObserver::class);
        User::observe(UserObserver::class);
    }
}
