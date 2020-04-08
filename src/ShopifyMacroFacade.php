<?php

namespace Cian\Shopify;

use Cian\Shopify\ShopifyMacro;
use Illuminate\Support\Facades\Facade;

class ShopifyMacroFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return ShopifyMacro::class;
    }
}
