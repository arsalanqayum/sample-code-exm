<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static boolean sendSMS(string $to,string $body, string|null $from = null,string|null $mediaUrl = null)
 * @method static string generateVideoRoom(string $name, string $identity = null, int $ttl = null)
 */
class Twilio extends Facade
{
    /** @return string */
    protected static function getFacadeAccessor()
    {
        return 'App\Facades\Twilio\Twilio';
    }
}