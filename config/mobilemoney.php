<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Environnement (sandbox / production)
    |--------------------------------------------------------------------------
    */
    'env' => env('MOBILE_MONEY_ENV', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Providers (MTN, Moov, Celtis, etc.)
    |--------------------------------------------------------------------------
    | Clés API et URLs. En production, utiliser des variables d'environnement.
    */
    'providers' => [
        'mtn' => [
            'api_url' => env('MTN_API_URL', 'https://api.mtn.com/v1'),
            'sandbox_url' => env('MTN_SANDBOX_URL', 'https://sandbox.mtn.com/v1'),
            'api_key' => env('MTN_API_KEY'),
            'api_secret' => env('MTN_API_SECRET'),
            'subscription_key' => env('MTN_SUBSCRIPTION_KEY'),
        ],
        'moov' => [
            'api_url' => env('MOOV_API_URL', 'https://api.moov-africa.com/v1'),
            'sandbox_url' => env('MOOV_SANDBOX_URL', 'https://sandbox.moov-africa.com/v1'),
            'api_key' => env('MOOV_API_KEY'),
            'api_secret' => env('MOOV_API_SECRET'),
        ],
        'celtis' => [
            'api_url' => env('CELTIS_API_URL', 'https://api.celtis.com/v1'),
            'sandbox_url' => env('CELTIS_SANDBOX_URL', 'https://sandbox.celtis.com/v1'),
            'api_key' => env('CELTIS_API_KEY'),
            'api_secret' => env('CELTIS_API_SECRET'),
        ],
    ],

    'default' => [
        'api_url' => env('MOBILE_MONEY_DEFAULT_URL'),
        'sandbox_url' => env('MOBILE_MONEY_SANDBOX_URL'),
        'api_key' => env('MOBILE_MONEY_API_KEY'),
    ],

];
