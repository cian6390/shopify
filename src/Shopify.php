<?php

namespace Cian\Shopify;

use Cian\Shopify\Services\OrderService;

class Shopify
{
    /**
     * @var \GuzzleHttp\Client $http
     */
    protected $http;

    /**
     * @var array $config
     */
    protected $config;

    /**
     * @var \Cian\Shopify\Services\OrderService $order
     */
    protected $orderService;

    public function __construct($http, array $config)
    {
        $this->http = $http;

        $this->config = $config;

        $this->orderService = $this->makeService(OrderService::class);
    }

    public function getOrderService()
    {
        return $this->orderService;
    }

    public function makeService($class)
    {
        if (function_exists('app')) {
            return app($class, [
                'http' => $this->http,
                'config' => $this->config
            ]);
        }

        return new $class($this->http, $this->config);
    }
}