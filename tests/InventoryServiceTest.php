<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;
use Cian\Shopify\Tests\TestCase;

class InventoryServiceTest extends TestCase
{
    public function test_get_inventory_levels_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        
        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/inventory_levels.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'query' => ['foo' => 'bar']
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->getInventoryLevels(['foo' => 'bar']);
    }

    public function test_get_locations_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        
        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/locations.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'query' => []
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->getLocations();
    }
}
