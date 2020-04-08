<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;
use Cian\Shopify\Tests\TestCase;

class CustomerServiceTest extends TestCase
{

    public function test_get_customers_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        
        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/customers.json";

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

        $shopify->setWebsite('tw')->getCustomers(['foo' => 'bar']);
    }

    public function test_get_specific_customer_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        
        $expectId = 'abc123';
        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/customers/{$expectId}.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->getCustomer($expectId);
    }

    public function test_search_customers_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        
        $expectMethod = 'GET';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/customers/search.json";

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

        $shopify->setWebsite('tw')->searchCustomers(['foo' => 'bar']);
    }

    public function test_create_customer_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        
        $expectMethod = 'POST';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/customers.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => ['customer' => ['foo' => 'bar']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->createCustomer(['foo' => 'bar']);
    }

    public function test_update_customer_api()
    {
        $website = 'tw';
        $config = $this->getConfig($website);
        
        $expectId = 1;
        $expectMethod = 'PUT';
        $expectURL = "https://{$config['url']}/admin/api/2020-01/customers/{$expectId}.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => ['customer' => ['foo' => 'bar']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $shopify->setWebsite('tw')->updateCustomer($expectId, ['foo' => 'bar']);
    }
}
