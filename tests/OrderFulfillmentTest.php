<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;
use Cian\Shopify\Tests\TestCase;

class OrderFulfillmentTest extends TestCase
{
    public function test_get_order_fulfillments_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '3345678';

        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}/fulfillments.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->getOrderFulfillments($orderId);

        $this->assertEquals($response->getBody(), []);
    }

    public function test_create_order_fulfillment_api()
    {
        $website = 'tw';

        $config = $this->getConfig($website);

        $expectMethod = 'POST';

        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/1/fulfillments.json";

        $fulfillment = ['foo' => 'bar'];

        $payload = ['fulfillment' => $fulfillment];
        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => $payload
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, []));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->createOrderFulfillment(1, $payload);
    }

    public function test_update_order_fulfillment_api()
    {
        $website = 'tw';

        $config = $this->getConfig($website);

        $expectMethod = 'PUT';

        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/1/fulfillments/2.json";

        $fulfillment = ['foo' => 'bar'];

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => ['fulfillment' => $fulfillment]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, []));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->updateOrderFulfillment(1, 2, ['fulfillment' => $fulfillment]);
    }

    public function test_cancel_order_fulfillment_api()
    {
        $website = 'tw';

        $config = $this->getConfig($website);

        $expectMethod = 'POST';

        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/1/fulfillments/2/cancel.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, []));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->cancelOrderFullment(1, 2);
    }
}
