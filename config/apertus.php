<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Apertus API Key
    |--------------------------------------------------------------------------
    |
    | Your Apertus API key is used to authenticate requests made from your
    | application to the Apertus public services. You can generate and manage
    | your API keys on https://platform.publicai.co/settings/api-keys
    |
    */

    'api_key' => env('APERTUS_API_KEY'),

    /*
     |--------------------------------------------------------------------------
     | Apertus User Agent
     |--------------------------------------------------------------------------
     |
     | This user agent string is sent with each request to the Apertus API.
     | You can customize it to include your application name or other details.
     | By default, it is set to 'Apertus-Laravel-Client/1.0.0'.
     |
     */

    'user_agent' => env('APERTUS_USER_AGENT', 'Apertus-Laravel-Client/1.0.0'),

    /*
    |--------------------------------------------------------------------------
    | Apertus Base URL
    |--------------------------------------------------------------------------
    |
    | This URL is the base endpoint for all Apertus API requests. While it's
    | set to Apertus default API server, you can change it for self-hosted
    | models or different test environments (if applicable, in the future).
    |
    */

    'base_url' => env('APERTUS_BASE_URL', 'https://api.publicai.co'),

    /*
    |--------------------------------------------------------------------------
    | Apertus Timeout
    |--------------------------------------------------------------------------
    |
    | This configuration option defines the maximum duration (in seconds) that
    | your application will wait for a response when making requests to the
    | Apertus API. By default, this value is set to 60 seconds. If you wish
    | to disable the timeout entirely, you can set this value to 0.
    |
    */

    'timeout' => env('APERTUS_TIMEOUT', 60),
];
