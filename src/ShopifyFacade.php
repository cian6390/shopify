<?php

namespace Cian\Shopify;

use Cian\Shopify\Shopify;
use Illuminate\Support\Facades\Facade;

class ShopifyFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return Shopify::class;
    }
}
