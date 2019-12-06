<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    /*
     * Socialite Credentials
     * Redirect URL's need to be the same as specified on each network you set up this application on
     * as well as conform to the route:
     * http://localhost/public/login/SERVICE
     * Where service can github, facebook, twitter, google, linkedin, or bitbucket
     * Docs: https://github.com/laravel/socialite
     * Make sure 'scopes' and 'with' are arrays, if their are none, use empty arrays []
     */
    'allowed_socialites' => explode(',', env('SOCIALITE_ENABLES', 'wechat,qq,weibo')),

    'wechat' => [
        'client_id'     => env('WECHAT_CLIENT_ID'),
        'client_secret' => env('WECHAT_CLIENT_SECRET'),
        'redirect'      => env('WECHAT_REDIRECT'),
        'scopes'        => [],
        'with'          => [],
    ],

    'qq' => [
        'client_id'     => env('QQ_CLIENT_ID'),
        'client_secret' => env('QQ_CLIENT_SECRET'),
        'redirect'      => env('QQ_REDIRECT'),
        'scopes'        => [],
        'with'          => [],
    ],

    'weibo' => [
        'client_id'     => env('WEIBO_CLIENT_ID'),
        'client_secret' => env('WEIBO_CLIENT_SECRET'),
        'redirect'      => env('WEIBO_REDIRECT'),
        'scopes'        => [],
        'with'          => [],
    ],
];
