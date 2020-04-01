<?php

namespace Cian\Shopify\Tests;

use Mockery;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Mockery\Exception\InvalidCountException;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function tearDown(): void
    {
        if (class_exists('Mockery')) {
            if ($container = Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }

            try {
                Mockery::close();
            } catch (InvalidCountException $e) {
                if (!Str::contains($e->getMethodName(), ['doWrite', 'askQuestion'])) {
                    throw $e;
                }
            }
        }
    }

    public function mock(string $className)
    {
        return Mockery::mock($className);
    }

    public function getMockClient()
    {
        return $this->mock(Client::class);
    }
}
