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
        //         'created_at_min' => \Carbon\Carbon::parse('2020-04-08 12:00:00', 'Asia/Taipei')->format('Y-m-d\TH:i:sP')
        //     ]);
        
        // dd(count($orders));
    }
}