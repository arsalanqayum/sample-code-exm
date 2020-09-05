<?php

namespace App\Traits\Stripe;

use App\Exceptions\StripeException;
use Illuminate\Support\Facades\Log;
use Stripe\Account as StripeAccount;

trait Account
{
    /** @var \Stripe\Account */
    protected $account;

    /**
     * Create custom account
     *
     * @param array $data
     * @return mixed|null
     */
    public function createAccount($data)
    {
        $createData = [
            'tos_acceptance' => [
                'date' => time(),
                'ip' => $_SERVER['REMOTE_ADDR'],
            ],
            'business_type' => 'individual',
            'country' => 'US',
            'type' => 'custom',
            'requested_capabilities' => ['card_payments', 'transfers'],
        ];

        $default = $this->arrangeData($data);

        $result = array_merge($createData, $default);

        try {
            $account = StripeAccount::create($result);

            return $account;
        } catch (\Throwable $th) {
            throw new StripeException($th);
        }
    }

    /**
     * Retrieve te details of an stripe account
     *
     * @param string $account_id
     * @return mixed|null
     */
    public function retrieve($account_id)
    {
        try {
            $account = StripeAccount::retrieve($account_id);
            $this->account = $account;
            return $this->account;
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Update account
     *
     * @param string $account_id
     * @param array $data
     * @return mixed|null
     */
    public function updateAccount($account_id, $data)
    {
        try {
            $arrangeData = $this->arrangeData($data);
            $account = StripeAccount::update($account_id, $arrangeData);

            return $account;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            return null;
        }
    }

    /**
     * Arrange data to be send to stripe
     *
     * @param array $data
     * @param string $type
     * @return array
     */
    public function arrangeData($data)
    {
        $dob = explode('-', $data['dob']);// split the - inside date string e.g 10-02-1996 = ['10', '02','96']

        return [
            'email' => $data['email'],
            'business_profile' => [
                'mcc' => '5045',
                'url' => 'https://app.ownerchat.com'
            ],
            'settings' => [
                'payouts' => [
                    'schedule' => [
                        'interval' => 'manual'
                    ]
                ]
            ],
            'individual' => [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                // 'gender' => $data['gender'],
                'phone' => $data['phone'],
                'ssn_last_4' => $data['ssn'],
                'address' => [
                    'city' => $data['city'],
                    'country' => 'US',
                    'line1' => $data['line1'],
                    'line2' => $data['line2'],
                    'state' => $data['state'],
                    'postal_code' => $data['postal_code']
                ],
                'dob' => [
                    'day' => $dob[0],
                    'month' => $dob[1],
                    'year' => $dob[2],
                ]
            ]
        ];
    }

    /**
     * store stripe connect external account
     *
     * @param array $data
     * @return mixed|null
     */
    public function createExternalAccount($data)
    {
        $stripeAccount = auth()->user()->stripeAccount;

        try {
            $account = StripeAccount::createExternalAccount(
                $stripeAccount->account_id,
                [
                    'external_account' => [
                        'object' => 'bank_account',
                        'country' => 'US',
                        'currency' => 'usd',
                        'routing_number' => $data['routing_number'],
                        'account_number' => $data['account_number'],
                    ]
                ]
            );

            return $account;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());

            return null;
        }
    }

    /**
     * Get requirements of stripe account
     *
     * @return array
     */
    public function accountRequirements()
    {
        return $this->account ? $this->account->requirements : [];
    }
}