<?php

namespace Cian\Shopify\Http\Middleware;

use Closure;
use Cian\Shopify\Exceptions\InvalidHmacHashException;
use Cian\Shopify\Exceptions\MissingWebsiteSecretException;

class VerifyWebHookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $website = $request->route('website');

        $secret = $this->getWebsiteSecret($website);
        
        if (is_null($secret)) {
            throw new MissingWebsiteSecretException($website);
        }
        
        $expectHmacHash = $this->computeHmacHash($secret);

        $invalid = $expectHmacHash !== $request->headers->get('X-Shopify-Hmac-Sha256', null);

        if ($invalid) {
            throw new InvalidHmacHashException;
        }

        return $next($request);
    }

    protected function computeHmacHash($secret)
    {
        $data = file_get_contents('php://input');

        return base64_encode(hash_hmac('sha256', $data, $secret, true));
    }

    /**
     * Get specific website secret.
     * 
     * @param string $website
     * @return string|null
     */
    public function getWebsiteSecret($website)
    {
        return config("shopify.websites.{$website}.secret", null);
    }
}