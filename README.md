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
$response->getNextLink(); // null or next page api url string.
$nextPageResponse = $response->callNextPage();  // null or \Cian\Shopify\Response object

$response->hasPreviousPage(); // boolean
$response->getPreviousLink(); // null or previous page api url string.
$previousPageResponse = $response->callNextPage();  // null or \Cian\Shopify\Response object

$response->isLastPage(); // boolean

/**
 * This method get content from guzzle response.
 * and run json_decode brefore return.
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

### ShopifyMacro

That say you want get data easily and you don't care performance.  
For example, you want get all result of a specific customers search, You don't want handle pagination.  
Then you can use this class. 🍻🍻🍻  

### searchCustomers
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
            // search options ...
        ];

        // You will just get result instead of \Cian\Shopify\Response instance.
        $customers = $this->shopifyMacro->searchCustomers($options)

        // do something with customers ...
    }
}
```
