<?php

return [
    'video' => [
        'sid' => env('TWILIO_VIDEO_SID',null),
        'secret' => env('TWILIO_VIDEO_SECRET', null),
        'key_type' => env("TWILIO_KEY_TYPE", 'standard')
    ]
];