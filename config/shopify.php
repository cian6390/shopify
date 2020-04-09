<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cian\Shopify Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls default shopify api version and retries.
    | You can use Shopify setters to replace these option before api call.
    |
    */

    'defaults' => [
        'api_version' => '2020-01',
        'api_retries' => 3
    ],

    /*
    |--------------------------------------------------------------------------
    | Websites
    |--------------------------------------------------------------------------
    |
    | You may have many shopify store, that why we provide array here.
    | If you only have one store in this option, ShopifyServiceProvider will
    | call setWebsite autolmally. You don't need call it manually.
    | Otherwise you need call setWebsite before API call.
    |
    | The key of websites array can be any string.
    | You will use it as setWebsite value: ->setWebsite('mystore')
    |
    */

    'websites' => [
        'mystore' => [
            'url' => env('SHOPIFY_MYSTORE_URL'),
            'credential' => [
                'key' => env('SHOPIFY_MYSTORE_API_KEY'),
                'password' => env('SHOPIFY_MYSTORE_API_PASSWORD')
            ]
        ]
    ]
];
