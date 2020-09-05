<?php

namespace App\Services;

use App\Facades\Twilio;
use App\Verification;

class VerificationService
{
    /**
     * Send verification service to given phone number.
     * The verification code will store in verifications table
     *
     * @param mixed $model
     * @return void
     */
    public function sendVerification($model)
    {
        $random_number = mt_rand(100000, 999999);
        $body = __('auth.verification_code', ['code' => $random_number]);

        $verification = new Verification();
        $verification->code = $random_number;

        if($model->verification()->save($verification)) {
            Twilio::sendSMS($model->phone, $body);
        }
    }
}