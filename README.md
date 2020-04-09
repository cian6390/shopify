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
            ->getOrders($options);

        // do something with orders ...
    }
}
```
