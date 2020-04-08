<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Client;
use Cian\Shopify\Tests\TestCase;

class ShopifyMacroTest extends TestCase
{
    public function test_get_orders_api()
    {
        $shopifyMacro = $this->getShopifyMacro(new Client, [
            'websites' => [
                'tw' => [
                    'url' => '',
                    'credential' => [
                        'key' => '',
                        'password' => ''
                    ]
                ]
            ]
        ]);

        // $orders = $shopifyMacro
        //     ->setWebsite('tw')
        //     ->getOrders([
        //         'limit' => 250,
        //         'created_at_min' => '2020-04-08T12:00:00+08:00'
        //     ]);
        
        // dd(count($orders));
    }
}