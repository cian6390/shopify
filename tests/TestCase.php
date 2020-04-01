<?php

namespace Cian\Shopify\Tests;

use Mockery;
use GuzzleHttp\Client;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function mock(string $className)
    {
        return Mockery::mock($className);
    }

    public function getMockClient()
    {
        return $this->mock(Client::class);
    }
}
