<?php

return [
    'defaults' => [
        'api_version' => '2020-01',
        'api_retries' => 3
    ],
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
