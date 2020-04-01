<?php

namespace Cian\Shopify\Exceptions;

use Exception;

class LimitCallException extends Exception
{
    public function __construct()
    {
        parent::__construct('Request times out of set.');
    }
}