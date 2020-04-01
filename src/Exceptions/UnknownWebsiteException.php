<?php

namespace Cian\Shopify\Exceptions;

use Exception;

class UnknownWebsiteException extends Exception
{
    public function __construct($website)
    {
        parent::__construct("Website {$website} setting not exist in config.");
    }
}