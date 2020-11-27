<?php

namespace Cian\Shopify\Tests;

use Cian\Shopify\GraphQL\Shopify;
use GuzzleHttp\Client;

class GraphShopifyTest extends TestCase
{

    protected function getGraphShopify()
    {
        $domain = '';
        $password = '';
        $shopify = new Shopify(new Client, compact('domain', 'password'));

        return $shopify;
    }

    // TODO: Test GraphQL API
    public function test_get_order_api()
    {
        $shopify = $this->getGraphShopify();

        $orderId = '';

        $shopify->getOrder($orderId);
    }
}