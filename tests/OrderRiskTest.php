<?php


namespace Cian\Shopify\Tests;


use GuzzleHttp\Psr7\Response;

class OrderRiskTest extends TestCase
{
    public function test_list_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '4455667788';

        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}/risks.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'query' => []
        ];

        $expectResponseBoday = [
            'risks' => [
                [
                    // risk fields, here just keep empty is fine.
                ]
            ]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode($expectResponseBoday)));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->listDraftOrder($orderId);

        $this->assertCount(1, $response->getBody()['draft_orders']);
    }
}