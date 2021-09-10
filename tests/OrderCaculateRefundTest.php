<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;

class OrderCaculateRefundTest extends TestCase
{
    public function test_calculate_refund_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        $orderId = '4455667788';
        $data = [
            'refund' => [
                'shipping' => [
                    'full_refund' => true
                ],
                'refund_line_items' => [
                    'line_item_id' => 518995019,
                    'quantity' => 1,
                    'restock_type' => "no_restock"
                ]
            ]
        ];

        $expectedMethod = 'POST';
        $expectedURL = "https://{$config['url']}/admin/api/2020-01/orders/{$orderId}/refunds/calculate.json";

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

        $shopify->setWebsite('tw')->calculateOrderRefund($orderId, $data);
    }
}
