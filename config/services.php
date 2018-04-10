<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Organization::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        // 'client_id' => '180949979137087',
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        // 'client_secret' => 'aedc8ae916a1fd9fc1905d479a3f1ee7',
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        // 'redirect' => 'http://localhost:8000/login-social/facebook/callback',
        'redirect' => env('FACEBOOK_LOGIN_REDIRECT'),
    ],

];
