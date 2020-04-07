<?php

namespace Cian\Shopify\Tests;

use Mockery;
use GuzzleHttp\Client;
use Cian\Shopify\Shopify;
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

    protected function getShopify($client, $config = [])
    {
        $config = array_merge($config, $this->getConfig());

        return new Shopify($client, $config);
    }

    protected function getConfig($website = null)
    {
        $config = [
            'defaults' => [
                'api_version' => '2020-01',
                'api_retries' => 3
            ],
            'websites' => [
                'tw' => [
                    'url' => 'store.myshopify.com',
                    'credential' => [
                        'key' => 'key001',
                        'password' => 'zxcvbn'
                    ]
                ]
            ]
        ];

        if ($website) {
            return $config['websites'][$website];
        }

        return $config;
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
