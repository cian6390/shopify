<?php

namespace Cian\Shopify;

use Exception;
use Cian\Shopify\Exceptions\LimitCallException;
use GuzzleHttp\Exception\BadResponseException;
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
    public function call($method, $url, $options = [], $tries = 1, $delay = 1)
    {
        $tried = 0;

        do {
            $response = $this->send($method, $url, $options);

            if (!is_null($response)) {
                return $response;
            }

            $tried += 1;

            if ($tried >= $tries) {
                throw new LimitCallException($response);
            } else {
                $shouldRetry = true;

                sleep($delay);
            }

        } while ($shouldRetry);
    }

    protected function send($method, $url, $options) {
        try {
            return $this->http->request($method, $url, $options);
        } catch (ClientException $e) {  // this throw when get 4xx server error.
            $response = $e->getResponse();

            $statusCode = $response->getStatusCode();

            // 除了 429 的例外，一率交給應用層處理
            // 429 代表 Shopify 正在限制我們的請求頻率，使用回傳 null 來表示。
            // 外層可以根據是不是 null 來決定要不要重試
            $retryStatusCode = 429;
            if ($statusCode !== $retryStatusCode) {
                throw $e;
            } else {
                return null;
            }
        } catch (ServerException $e) {  // this throw when get 5xx server error.
            throw $e;
        } catch (Exception $e) { // this throw when our code issue or guzzle bug.
            throw $e;
        }
    }
}
