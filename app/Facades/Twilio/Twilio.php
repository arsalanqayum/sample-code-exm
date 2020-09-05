<?php

namespace App\Facades\Twilio;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class Twilio extends Client
{
    /**
     * Send SMS
     *
     * @param string $to
     * @param string|null $from
     * @param string $body
     * @param string|null $mediaUrl
     * @return boolean
     */
    public function sendSMS($to, $body, $from = null, $mediaUrl = null)
    {
        $options = [
            'from' => $from ?? config('sms.twilio.number'),
            'body' => $body
        ];

        if($mediaUrl) {
            $options['mediaUrl'] = $mediaUrl;
        }

        return app()->env != 'local' ? $this->messages->create($to, $options) : null;
    }

    /**
     * Generate new token for video room
     *
     * @param string $name room name
     * @param string $identity user identity
     * @param int $ttl
     * @return string jwt
     */
    public function generateVideoRoom($name, $identity = null, $ttl = null)
    {
        $token = new AccessToken(
            $this->accountSid,
            config('twilio.video.sid'),
            config('twilio.video.secret'),
            $ttl ?? 3600,
            $identity
        );

        $grant = new VideoGrant();
        $grant->setRoom($name);
        $token->addGrant($grant);

        return $token->toJWT();
    }
}
