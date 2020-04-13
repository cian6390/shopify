<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;
use Cian\Shopify\Tests\TestCase;

class OrderServiceTest extends TestCase
{
    public function test_auto_merge_fields_of_get_orders_api()
    {
        $config = $this->getConfig();
        $config['apis'] = [
            'getOrders' => [
                'enable' => true,
                'fields' => ['foo', 'bar']
            ]
        ];
        $expectMethod = 'GET';

        $expectURL = "https://{$config['websites']['tw']['url']}/admin/api/2020-01/orders.json";

        $expectOptions = [
            'auth' => [$config['websites']['tw']['credential']['key'], $config['websites']['tw']['credential']['password']],
            'query' => [
                'fields' => 'foo,bar'
            ]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock, $config);

        $shopify->setWebsite('tw')->getOrders();
    }
    public function test_get_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '3345678';

        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $fakeOrder = ['id' => $orderId];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeOrder)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->getOrder($orderId);

        $this->assertEquals($response->getBody(), $fakeOrder);
    }

    public function test_list_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);

        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders.json";

        $expectRows = 1;
        $expectCreateAtMin = '2020-03-31T09:00:00+08:00';

        $expectArguments = [
            'limit' => $expectRows,
            'created_at_min' => $expectCreateAtMin
        ];

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'query' => $expectArguments
        ];

        $expectResponseBoday = [
            'orders' => [
                [
                    // order fields, here just keep empty is fine.
                ]
            ]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($expectResponseBoday)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->getOrders($expectArguments);

        $this->assertCount(1, $response->getBody()['orders']);
    }

    public function test_count_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/count.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $fakeResponseBody = ['count' => 1];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeResponseBody)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->countOrder();

        $this->assertEquals($response->getBody(), $fakeResponseBody);
    }

    public function test_close_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '3345678';

        $expectMethod = 'POST';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}/close.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $fakeOrder = ['id' => $orderId];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeOrder)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->closeOrder($orderId);

        $this->assertEquals($response->getBody(), $fakeOrder);
    }

    public function test_open_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '3345678';

        $expectMethod = 'POST';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}/open.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $fakeRespons = [
            'order' => [
                'id' => $orderId
            ]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeRespons)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->openOrder($orderId);

        $this->assertEquals($response->getBody(), $fakeRespons);
    }

    public function test_cancel_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '3345678';

        $expectMethod = 'POST';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}/cancel.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $fakeRespons = [
            'order' => [
                'id' => $orderId
            ]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeRespons)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->cancelOrder($orderId);

        $this->assertEquals($response->getBody(), $fakeRespons);
    }

    public function test_create_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '3345678';
        $lineitems = [
            [
                'variant_id' => 447654529,
                'quantity' => 1
            ]
        ];
        $order = [
            'line_items' => $lineitems
        ];

        $expectMethod = 'POST';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => ['order' => $order]
        ];

        $fakeRespons = [
            'order' => [
                'id' => $orderId,
                'line_items' => $lineitems
            ]
        ];
        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeRespons)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->createOrder($order);

        $this->assertEquals($response->getBody(), $fakeRespons);
    }

    public function test_update_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '3345678';

        $expectMethod = 'PUT';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}.json";
        $data = [
            'order' => [
                'id' => $orderId,
                'note' => 'test'
            ]
        ];

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => ['order' => $data]
        ];

        $fakeRespons = [
            'order' => [
                'id' => $orderId,
                'note' => 'test'
            ]
        ];
        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeRespons)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->updateOrder($orderId, $data);

        $this->assertEquals($response->getBody(), $fakeRespons);
    }

    public function test_delete_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '3345678';

        $expectMethod = 'DELETE';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, []));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->deleteOrder($orderId);
    }
}
