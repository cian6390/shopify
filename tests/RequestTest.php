<?php

namespace Cian\Shopify\Tests;

use Cian\Shopify\Shopify;
use Cian\Shopify\Request;
use Cian\Shopify\Tests\TestCase;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Cian\Shopify\Exceptions\LimitCallException;

class RequestTest extends TestCase
{
    /** @test */
    public function it_will_keep_fire_api_until_leak_limit()
    {
        $this->expectException(LimitCallException::class);

        $mockClient = $this->getMockClient();

        $exception = new ClientException(
            'Too Many Requests',
            new GuzzleRequest('GET', 'https://example.com'),
            new GuzzleResponse(429)
        );

        $mockClient->shouldReceive('request')
            ->times(1)
            ->with('GET', 'https://example.com', [])
            ->andThrow($exception);

        $request = new Request($mockClient);

        $request->call('GET', 'https://example.com', [], 1);
    }

    public function makeShopify()
    {
        return new Shopify(new \GuzzleHttp\Client, [
            'defaults' => [
                'api_version' => '2020-01',
                'api_retries' => 3
            ],
            'websites' => [
                'mystore' => [
                    'url' => 'rhinoshieldtaiwan.myshopify.com',
                    'credential' => [
                        'key' => '252f6a3c29646ca7ef49454f36699c56',
                        'password' => '8a0e5b25aca858f5563b528317355a99'
                    ]
                ]
            ]
        ]);
    }
}
