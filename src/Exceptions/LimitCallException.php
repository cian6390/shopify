<?php

namespace Cian\Shopify\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Response;

class LimitCallException extends Exception
{
    /**
     * @var Response $response
     */
    public $response;

    public function __construct($response)
    {
        parent::__construct('Request times out of set.');
        $this->response = $response;
    }
}