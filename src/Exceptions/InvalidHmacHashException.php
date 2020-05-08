<?php

namespace Cian\Shopify\Exceptions;

use Exception;

class InvalidHmacHashException extends Exception
{
    public function __construct()
    {
        parent::__construct("Invalid hmac hash header.");
        $this->code = 401;
    }
}