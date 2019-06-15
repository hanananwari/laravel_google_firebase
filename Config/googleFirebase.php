<?php

return [

    'middleware' => [
        'replacement' => [],
        'additional' => []
    ],
    'firebase' => [
        'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
        'service_account_path' => env('FIREBASE_SERVICE_ACCOUNT_PATH'),
        'server_key' => env('FIREBASE_SERVER_KEY'),
    ],

    'topicGroups' => [],
];
