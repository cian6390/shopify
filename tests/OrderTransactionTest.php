<?php


namespace Cian\Shopify\Tests;


use GuzzleHttp\Psr7\Response;

class OrderTransactionTest extends TestCase
{
    public function test_get_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '4455667788';
        $data = [
            'since_id' => 801038806
        ];

        $expectedMethod = 'GET';
        $expectedURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}/transactions.json";
        $expectedOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'query' => $data
        ];

        $expectedResponseBody = [
            'transactions' => [
                //...
            ]
        ];

        $mock = $this->getMockClient();
        $mock->shouldReceive('request')
            ->once()
            ->with($expectedMethod, $expectedURL, $expectedOptions)
            ->andReturn(new Response(200, [], json_encode($expectedResponseBody)));

        $shopify = $this->getShopify($mock);
        $response = $shopify->setWebsite('tw')->listOrderTransactions($orderId, $data);

        $this->assertEquals($response->getBody(), $expectedResponseBody);
    }
}