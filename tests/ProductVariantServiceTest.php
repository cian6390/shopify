<?php

namespace Cian\Shopify\Tests;

use GuzzleHttp\Psr7\Response;
use Cian\Shopify\Tests\TestCase;

class ProductVariantServiceTest extends TestCase
{
    public function test_get_product_variant_api()
    {
        $website = 'tw';

        $config = $this->getConfig($website);

        $expectMethod = 'GET';

        $variantId = '123';

        $expectURL = "https://{$config['url']}/admin/api/2020-01/variants/{$variantId}.json";

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')->getProductVariant($variantId);

        $this->assertEquals($response->getBody(), []);
    }

    public function test_update_product_variant_api()
    {
        $website = 'tw';

        $config = $this->getConfig($website);

        $expectMethod = 'PUT';

        $varianId = 'aabbccd';

        $expectURL = "https://{$config['url']}/admin/api/2020-01/variants/$varianId.json";

        $expectVariants = ['foo' => 'bar'];

        $expectOptions = [
            'auth' => [$config['credential']['key'], $config['credential']['password']],
            'json' => [
                'variant' => $expectVariants
            ]
        ];

        $mock = $this->getMockClient();

        $mock->shouldReceive('request')
            ->once()
            ->with($expectMethod, $expectURL, $expectOptions)
            ->andReturn(new Response(200, [], json_encode([])));

        $shopify = $this->getShopify($mock);

        $response = $shopify->setWebsite('tw')
            ->updateProductVariant($varianId, $expectVariants);

        $this->assertEquals($response->getBody(), []);
    }
}
