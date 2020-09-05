<?php

/**
 * SMS Third Party Services
 */


return [
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'secret' => env('TWILIO_TOKEN'),
        'number' => env('TWILIO_NUMBER'),
    ]
];