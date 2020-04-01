<?php

namespace Cian\Shopify\Exceptions;

use Exception;

class UnsetWebsiteException extends Exception
{
    public function __construct()
    {
        parent::__construct('Please call setWebsite($website) before call api.');
    }
}