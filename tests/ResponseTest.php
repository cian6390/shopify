<?php

namespace Cian\Shopify\Tests;

use Cian\Shopify\Shopify;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Cian\Shopify\Tests\TestCase;
use Cian\Shopify\Response;

class ResponseTest extends TestCase
{
    /** @test */
    public function it_can_handle_guzzle_response_body()
    {
        $expectBody = ['order' => []];

        $guzzleResponse = new GuzzleResponse(200, [], json_encode($expectBody));

        $response = new Response($guzzleResponse);

        $this->assertEquals($response->getBody(), $expectBody);
    }

    /** @test */
    public function it_can_handle_next_link_header()
    {
        $link = 'https://mystore.myshopify.com/admin/api/2019-07/products.json?page_info=hijgklmn&limit=3';
        $guzzleResponse = new GuzzleResponse(200, [
            'Link' => "<{$link}>; rel=\"next\""
        ]);

        $response = new Response($guzzleResponse);

        $this->assertTrue($response->hasNextLink());

        $this->assertEquals($response->getNextLink(), $link);
    }

    /** @test */
    public function it_can_handle_previous_link_header()
    {
        $link = 'https://mystore.myshopify.com/admin/api/2019-07/products.json?page_info=hijgklmn&limit=3';
        $guzzleResponse = new GuzzleResponse(200, [
            'Link' => "<{$link}>; rel=\"previous\""
        ]);

        $response = new Response($guzzleResponse);

        $this->assertTrue($response->hasPreviousLink());

        $this->assertEquals($response->getPreviousLink(), $link);
    }

    /** @test */
    public function isLastPage_method_should_return_true_when_is_last_page()
    {
        $link = 'https://mystore.myshopify.com/admin/api/2019-07/products.json?page_info=hijgklmn&limit=3';
        $guzzleResponse = new GuzzleResponse(200, [
            'Link' => "<{$link}>; rel=\"previous\""
        ]);

        $response = new Response($guzzleResponse);

        $this->assertTrue($response->isLastPage());
    }

    /** @test */
    public function is_can_handle_next_page_and_previous_page_at_sametime()
    {
        $nextLink = "https://mystore.myshopify.com/admin/api/2020-01/products.json?page_info=jsdnfjknsdkj&limit=250";

        $previousLink = "https://mystore.myshopify.com/admin/api/2020-01/products.json?page_info=dksnfkjsd&limit=250";

        $guzzleResponse = new GuzzleResponse(200, [
            'Link' => "<{$nextLink}>; rel=\"next\", <{$previousLink}>; rel=\"previous\""
        ]);

        $response = new Response($guzzleResponse);

        $this->assertEquals($response->getNextLink(), $nextLink);

        $this->assertEquals($response->getPreviousLink(), $previousLink);
    }

}
