<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id'     => '55153990187-nru61msr9fi79s8cdiv3hqebvlr0avqe.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect'      => 'http://admin.yummyfarm.be/api/auth/google/callback'
    ],

    'facebook' => [
        'client_id' => '333067848326474',
        'client_secret' => 'f5f9cbbf3ee511b6de40212d9f70feb4',
        'redirect' => "http://admin.yummyfarm.be/api/auth/facebook/callback",
    ],

];
