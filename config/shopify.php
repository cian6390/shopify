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
            'secret' => env('SHOPIFY_MYSTORE_SECRET'),
            'credential' => [
                'key' => env('SHOPIFY_MYSTORE_API_KEY'),
                'password' => env('SHOPIFY_MYSTORE_API_PASSWORD')
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Configure API presets.
    |--------------------------------------------------------------------------
    |
    | use shopify setApiPreset() tp apply.
    |
    */

    'api_presets' => [
        'common_order_fields' => [
            'fields' => implode(',', [
                // 'app_id',
                'billing_address',
                // 'browser_ip',
                'buyer_accepts_marketing',
                'cancel_reason',
                'closed_at',
                'created_at',
                'currency',
                'current_total_duties_set',
                'customer',
                'customer_locale',
                'discount_applications',
                'discount_codes',
                'email',
                'financial_status',
                'fulfillments',
                'fulfillment_status',
                'gateway',
                'id',
                'landing_site',
                'line_items',
                'location_id',
                'name',
                'note',
                'note_attributes',
                'number',
                'order_number',
                'original_total_duties_set',
                'payment_details',
                'payment_gateway_names',
                'phone',
                'presentment_currency',
                'processed_at',
                'processing_method',
                'referring_site',
                'refunds',
                'shipping_address',
                'shipping_lines',
                'source_name',
                'subtotal_price',
                'subtotal_price_set',
                'tags',
                'tax_lines',
                'taxes_included',
                'test',
                'token',
                'total_discounts',
                'total_discounts_set',
                'total_line_items_price',
                'total_line_items_price_set',
                'total_price',
                'total_price_set',
                'total_tax',
                'total_tax_set',
                'total_tip_received',
                'total_weight',
                'updated_at',
                'user_id',
                'order_status_url'
            ])
        ],
    ]
];
