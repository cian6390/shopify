<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;
use Cian\Shopify\Tests\TestCase;

class ProductServiceTest extends TestCase
{
    public function test_create_product_api()
    {
        $website = 'tw';

        $config = $this->getConfig($website);

        $expectMethod = 'POST';

        $product = [
            'foo' => 123
        ];

        $expectURL = "https://{$config['url']}/admin/api/2020-01/products.json";

        $payload = ['product' => $product];
        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => $payload
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->createProduct($payload);

        $this->assertEquals($response->getBody(), []);
    }

    public function test_get_product_api()
    {
        $website = 'tw';

        $config = $this->getConfig($website);

        $expectMethod = 'GET';

        $productId = 'aabbccd';

        $expectURL = "https://{$config['url']}/admin/api/2020-01/products/$productId.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->getProduct($productId);

        $this->assertEquals($response->getBody(), []);
    }

    public function test_get_products_api()
    {
        $website = 'tw';

        $config = $this->getConfig($website);

        $expectMethod = 'GET';

        $expectURL = "https://{$config['url']}/admin/api/2020-01/products.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->getProducts();

        $this->assertEquals($response->getBody(), []);
    }
}
