<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;
use Cian\Shopify\Tests\TestCase;

class MetafieldServiceTest extends TestCase
{
    public function test_search_metafields_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);

        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/metafields.json?metafield[owner_id]=3345678&metafield[owner_resource]=customer";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $params = [
            'owner_id' => '3345678',
            'owner_resource' => 'customer'
        ];

        $shopify->setWebsite('tw')->searchMetafields($params);
    }
}
