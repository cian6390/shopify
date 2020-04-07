# Shopify

⚠️⚠️⚠️ **This Package not complete yet, don't use it now.** ⚠️⚠️⚠️

Simple Shopify API package for PHP、Laravel。

- PHP 7.0+

## Installation

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
        'Shopify' => \Cian\Shopify\ShopifyFacade::class
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
        $options = [
            'limit' => 100,
            // more options of order list api ...
        ];

        $response = $this->shopify->getOrders($options);

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

$response = Shopify::getOrders();

$response->hasNextPage(); // boolean
$response->getNextLink(); // null|string, string is url witch is next page api link.

$response->hasPreviousPage();   // boolean
$response->getPreviousLink();   // null|string, string is url witch is previous page api link.

$response->isLastPage(); // boolean

/**
 * This method get content from guzzle response.
 * and run json_decode brefore return.
 * you can pass json_decode options via this method;
 */
$response->getBody();
```