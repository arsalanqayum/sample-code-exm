<?php

namespace App\Services;

use App\Company;
use App\CompanyUser;
use App\Contact;

class CompanyService
{
    /**
     * Get user Company by given slug
     *
     * @param string $slug
     * @return \App\Company
     */
    public function getUserCompany($slug)
    {
        return auth()->user()->companies()->whereSlug($slug)->firstOrFail();
    }

    /**
     * register owner to company user
     *
     * @param mixed $user
     * @param mixed $companySlug
     * @return void
     */
    public function registerToCompany($user, $companySlug)
    {
        $company = Company::whereSlug($companySlug)->firstOrFail();

        $contact = $company->contacts()->where('email', $user->email)->first();

        if($contact) {
            $contact->forceFill([
                'user_id' => $user->id,
                'status' => Contact::OWNER,
            ])->save();
        }

        CompanyUser::create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);
    }
}