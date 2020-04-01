<?php

namespace Cian\Shopify;

use GuzzleHttp\Exception\BadResponseException;

class Request
{
    /**
     * @var \GuzzleHttp\Client $http
     */
    protected $http;

    public function __construct($http)
    {
        $this->http = $http;
    }

    /**
     * @param string $method
     * @param string $string
     * @param array $options
     * @param int $tries
     * 
     * @return \GuzzleHttp\Psr7\Response
     */
    public function call($method, $url, $options, $tries = 1)
    {
        for ($i = 0; $i < $tries; $i++) {
            try {
                return $this->http->request($method, $url, $options);
            } catch (BadResponseException $e) {
                $status = $e->response->statusCode;

                if ($status === 429) {
                    sleep(250);
                    continue;
                }
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
}
