<?php


namespace Cian\Shopify\Tests;


use GuzzleHttp\Psr7\Response;

class OrderRefundTest extends TestCase
{
    public function test_create_refund_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '4455667788';
        $data = [
            'refund' => [
                'currency' => 'TWD',
                'notify' => true,
                'note' => 'wrong case',
                'shipping' => [
                    'full refund' => true
                ],
                'refund_line_items' => [
                    'line_item_id' => 518995019,
                    'quantity' => 1,
                    'restock_type' => 'return',
                    'location_id' => 487838322
                ],
                'transactions' => [
                    'parent_id' => 801038806,
                    'amount' => 500,
                    'kind' => 'refund',
                    'gateway' => 'abc'
                ]
            ]
        ];

        $expectedMethod = 'POST';
        $expectedURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}/refunds.json";

        $expectedOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => $data
        ];

        $expectedResponseBody = [
            'refund' => []
        ];

        $mock = $this->getMockClient();
        $mock->shouldReceive('request')
            ->once()
            ->with($expectedMethod, $expectedURL, $expectedOptions)
            ->andReturn(new Response(200, [], json_encode($expectedResponseBody)));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->createOrderRefund($orderId, $data);
    }
}