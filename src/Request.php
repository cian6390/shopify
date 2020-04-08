<?php

namespace Cian\Shopify;

use Exception;
use Cian\Shopify\Exceptions\LimitCallException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

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
     * @throws ClientException|ServerException|LimitCallException|\Exception
     */
    public function call($method, $url, $options = [], $tries = 1)
    {
        for ($i = 1; $i <= $tries; $i++) {
            $shouldRetry = $tries - $i > 0;
            return $this->send($method, $url, $options, $shouldRetry);
        }
    }

    protected function send($method, $url, $options, $shouldRetry) {
        try {
            return $this->http->request($method, $url, $options);
        } catch (ClientException $e) {  // this throw when get 4xx server error.
            $response = $e->getResponse();

            $statusCode = $response->getStatusCode();

            if ($statusCode === 429) {
                if ($shouldRetry) {
                    sleep(1);
                } else {
                    throw new LimitCallException;
                }
            } else {
                throw $e;
            }
        } catch (ServerException $e) {  // this throw when get 5xx server error.
            throw $e;
        } catch (Exception $e) { // this throw when our code issue or guzzle bug.
            throw $e;
        }
    }
}
