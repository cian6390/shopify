<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;

class DraftOrderTest extends TestCase
{
    public function test_get_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $draftOrderId = '3345678';

        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/draft_orders/{$draftOrderId}.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $fakeOrder = ['id' => $draftOrderId];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeOrder)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->getDraftOrder($draftOrderId);

        $this->assertEquals($response->getBody(), $fakeOrder);
    }

    public function test_list_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);

        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/draft_orders.json";

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
            'draft_orders' => [
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

        $response = $shopify->setWebsite('tw')->getDraftOrders($expectArguments);

        $this->assertCount(1, $response->getBody()['draft_orders']);
    }

    public function test_count_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/draft_orders/count.json";

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

        $response = $shopify->setWebsite('tw')->countDraftOrder();

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
        $data = [
            'draft_order' => [
                'line_items' => $lineitems
            ]
        ];

        $expectMethod = 'POST';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/draft_orders.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => $data
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

        $response = $shopify->setWebsite('tw')->createDraftOrder($data);

        $this->assertEquals($response->getBody(), $fakeRespons);
    }

    public function test_update_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $draftOrderId = '3345678';

        $expectMethod = 'PUT';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/draft_orders/{$draftOrderId}.json";
        $data = [
            'order' => [
                'id' => $draftOrderId,
                'note' => 'test'
            ]
        ];

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => $data
        ];

        $fakeRespons = [
            'order' => [
                'id' => $draftOrderId,
                'note' => 'test'
            ]
        ];
        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($fakeRespons)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->updateDraftOrder($draftOrderId, $data);

        $this->assertEquals($response->getBody(), $fakeRespons);
    }

    public function test_delete_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $draftOrderId = '3345678';

        $expectMethod = 'DELETE';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/draft_orders/{$draftOrderId}.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, []));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->deleteDraftOrder($draftOrderId);
    }

    public function test_complete_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $draftOrderId = '3345678';

        $expectMethod = 'PUT';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/draft_orders/{$draftOrderId}/complete.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, []));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->completeDraftOrder($draftOrderId);
    }

    public function test_create_invoice_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $draftOrderId = '3345678';
        $data = [
            'draft_order_invoice' => [
                'to' => 'first@example.com',
                'from' => 'steve@apple.com',
                'bcc' => [
                    'steve@apple.com'
                ],
                'subject' => 'Apple Computer Invoice',
                'custom message' => 'Thank you for ordering!'
            ]
        ];

        $expectMethod = 'POST';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/draft_orders/{$draftOrderId}/send_invoice.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => $data
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, []));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->createDraftOrderInvoice($draftOrderId, $data);
    }
}
