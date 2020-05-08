<?php

namespace Domains\Shopify\Tests\Unit;

use Cian\Shopify\Tests\TestCase;
use Cian\Shopify\Http\Middleware\VerifyWebHookMiddleware;
use Cian\Shopify\Exceptions\InvalidHmacHashException;
use Cian\Shopify\Exceptions\MissingWebsiteSecretException;
use Mockery;

class VerifyWebHookMiddlewareTest extends TestCase
{

    public function test_it_should_abort_500_if_store_secret_not_exist()
    {
        $this->expectException(MissingWebsiteSecretException::class);

        $request = $this->getRequest();

        $middleware = Mockery::mock(VerifyWebHookMiddleware::class . '[getWebsiteSecret]');

        $middleware->shouldReceive('getWebsiteSecret')
            ->once()
            ->with('tw')
            ->andReturn(null);

        $middleware->handle($request, function () {  });
    }

    public function test_it_should_abort_401_when_hmac_sha256_not_match()
    {
        $this->expectException(InvalidHmacHashException::class);

        $request = $this->getRequest();

        $middleware = Mockery::mock(VerifyWebHookMiddleware::class . '[getWebsiteSecret]');

        $middleware->shouldReceive('getWebsiteSecret')
            ->once()
            ->with('tw')
            ->andReturn('123');

        $middleware->handle($request, function () {  });
    }

    public function test_it_should_pass_middleware_when_everything_correct()
    {
        $request = $this->getRequest();

        $middleware = Mockery::mock(VerifyWebHookMiddleware::class . '[getWebsiteSecret]');

        $middleware->shouldReceive('getWebsiteSecret')
            ->once()
            ->with('tw')
            ->andReturn('test');

        $middleware->handle($request, function () { 
            $this->assertTrue(true);
         });
    }

    public function getRequest()
    {
        $request = (new class {
            public function __construct()
            {
                $this->headers = (new class {
                    public function get($key, $default = null)
                    {
                        $props = [
                            'X-Shopify-Hmac-Sha256' => 'rXEUjHnyGrnuxR6lx90rZoeS98DTU0rmayL3HGFSP7M='
                        ];
                        return $props[$key] ?? $default;
                    }
                });
            }

            public function route($key)
            {
                $props = [
                    'website' => 'tw'
                ];
                return $props[$key];
            }
        });

        return $request;
    }
}
