<?php
return [
    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */
    /**
     * Storage
     */
    'storage' => 'Session',
    /**
     * Consumers
     */
    'consumers' => [
        'Google' => [
            'client_id'     => env('GOOGLE_CONTACTS_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CONTACTS_CLIENT_SECRET'),
            'scope'         => [
                'userinfo_email',
                'userinfo_profile',
                'https://www.google.com/m8/feeds/'
            ],
        ],
    ]
];
