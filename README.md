# Shopify

Simple Shopify API package for PHP、Laravel。  

## Installation
### Requirements

- PHP 7.0+
- Laravel ^5|^6|^7

```
composer require cian/shopify
```

### Laravel

```shell
php artisan vendor:publish --provider="Cian\Shopify\ShopifyServiceProvider"
```

If your laravel version `<= 5.4`, don't forget to add a service provider and aliases.  

```php
// <Root>/config/app.php
[
    "providers" => [
        // other providers ...
        Cian\Shopify\ShopifyServiceProvider::class
    ],

    "aliases" => [
        // other aliases ...
        'Shopify' => \Cian\Shopify\ShopifyFacade::class,
        'ShopifyMacro' => \Cian\Shopify\ShopifyMacroFacade::class
    ]
]
```

## Usage

You need to check [Shopify API document](https://shopify.dev/docs/admin-api/rest/reference/) to get more knowledge of each API options.  

Here is an example demonstrate how to use this package in laravel.  

```php
<?php

namespace App\Services;

use Cian\Shopify\Shopify;

class GetShopifyOrdersService
{
    protected $shopify;

    public function __construct(Shopify $shopify)
    {
        $this->shopify = $shopify;
    }

    public function exec()
    {
        $response = $this->shopify
            ->setWebsite('mystore')
            ->getOrders([
                'limit' => 100,
                // more options of get orders api ...
            ]);

        // always get response body using this way.
        $orders = $response->getBody();

        return $orders;
    }
}

```

### Response

You will get `\Cian\Shopidy\Response` instance of each api call.  

This object provide you simple interface to access [Shopfiy Paginate Header](https://shopify.dev/tutorials/make-paginated-requests-to-rest-admin-api).

```php

namespace App;

// use laravel facade.
use Shopify;

$response = Shopify::setWebsite('mystore')->getOrders([/** options */]);

$response->hasNextPage(); // boolean
$response->getNextLink(); // null or next page api url string.

$response->hasPreviousPage(); // boolean
$response->getPreviousLink(); // null or previous page api url string.

$response->isLastPage(); // boolean

/**
 * This method get content from guzzle response.
 * and run json_decode before return.
 * you can pass json_decode options via this method,
 * here just show you the default values, all options are optional!
 */
$response->getBody(true, 512, 0);

/**
 * If you prefer handle response by your self.
 * you can get original response like below.
 */
$guzzleResponse = $response->getOriginalResponse();
```

## Configuration

### api_presets

We can provide some general stuff for specific api here.  

For Example:  
Your app only care the id, line_items, billing_address of order.  
Then you can make a preset like below:

```php
// config/shopify.php

return [
    // othere properties...
    'api_presets' => [
        // the key(my_order_common) can be any string, just don't duplicate.
        'my_order_common' => [
            'fields' => [
                'id',
                'line_items',
                'billing_address'
            ]
        ]
    ]
];
```

In your code

```php
<?php

namespace App;

use Cian\Cian\Shopify;

$shopify = new Shopify($guzzleClient, $config);

$keep = false;  // keep using this preset for each call or not, default is false.

$response = $shopify
    ->setWebsite('mystore')
    ->setApiPreset('my_order_common', $keep)
    ->getOrders([/** more options */]);
```

When your app call `setApiPreset` and provide options to api at same time,  
They will be merged, your context options will be respect.  

You may not know Shopify API has a known issue which is it may give us cached(expired) data.  
Shopify CS told us we can use `fields` parameter to force get fresh data.  
This feature is also useful for this issue. 🤘

### ShopifyMacro

That say you want get data easily and you don't care performance.  
For example, you want get all result of *getOrders* API, You don't want handle pagination.  
Then you can use this class. 🍻🍻🍻  

> Note: You may get memory issue when getting too large data.

#### Example

We are using dependency injection of demonstration below, but facade is also available.

```php
namespace App\Services;

use Cian\Shopify\ShopifyMacro;

class MyService
{
    protected $shopifyMacro;

    public function __construct(ShopifyMacro $shopifyMacro)
    {
        $this->shopifyMacro = $shopifyMacro;
    }

    public function exec()
    {
        $options = [
            'limit' => 250, // get 250 records per request.
            'created_at_min' => '2020-04-08T12:00:00+00:00' // set min date
            // other getOrders options ..
        ];

        // You will get response body instead of \Cian\Shopify\Response instance.
        $orders = $this->shopifyMacro
            ->setWebsite('mystore')
            /**
             * setFormatter is optional!
             * it can let getters return specific format.
             * this may decline some memory usage.
             */
            ->setFormatter(function ($order) {
                return [
                    'id' => $order['id']
                ];
            })
            ->getOrders($options);

        // do something with orders ...
    }
}
```
