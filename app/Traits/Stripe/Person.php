<?php

namespace App\Traits\Stripe;

use App\StripeAccount;
use Illuminate\Support\Facades\Log;
use Stripe\Account;

trait Person
{
    /**
     * Create person
     *
     * @param string $account_id
     * @param array $data
     * @return mixed|null
     */
    public function createPerson($account_id, $data)
    {
        $user = auth()->user();

        $dob = explode('-', $data['dob']);// split the - inside date string e.g 10-02-1996 = ['10', '02','96']

        try {
            $person = Account::createPerson(
                $account_id,
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'relationship' => [
                        'representative' => true,
                        'title' => 'owner',
                        'owner' => true,
                        'percent_ownership' => 100
                    ],
                    'dob' => [
                        'day' => $dob[0],
                        'month' => $dob[1],
                        'year' => $dob[2]
                    ],
                    'email' => $data['email'],
                    'address' => $data['address'],
                    'ssn_last_4' => $data['ssn'],
                    'phone' => $user->phone,
                ]
            );

            $sa = StripeAccount::where('account_id', $account_id)->first();
            $sa->person_id = $person['id'];
            $sa->save();

            return $person;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            return null;
        }
    }
}