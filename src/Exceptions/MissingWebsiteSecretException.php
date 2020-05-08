<?php

namespace Cian\Shopify\Exceptions;

use Exception;

class MissingWebsiteSecretException extends Exception
{
    public function __construct($website)
    {
        parent::__construct("Missing shopify store secret of site {$website}.");
        $this->code = 500;
    }
}