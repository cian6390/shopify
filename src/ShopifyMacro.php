<?php

namespace Cian\Shopify;

use Cian\Shopify\Shopify;
use Cian\Shopify\Exceptions\UnknownWebsiteException;

class ShopifyMacro
{
    protected $shopify;

    public function __construct(Shopify $shopify)
    {
        $this->shopify = $shopify;
    }

    /**
     * Set shopify api version.
     *
     * @param string $version
     * @return $this
     */
    public function setVersion($version)
    {
        $this->shopify->setVersion($version);

        return $this;
    }

    /**
     * Set target website.
     *
     * @param $website
     * @return $this
     * @throws UnknownWebsiteException
     */
    public function setWebsite($website)
    {
        $this->shopify->setWebsite($website);

        return $this;
    }

    /**
     * Set default retry times of request.
     *
     * @param int $retries
     * @return $this
     */
    public function setRetries(int $retries)
    {
        $this->shopify->setRetries($retries);

        return $this;
    }

    public function getOrders(array $options = [])
    {
        return $this->collectResults('getOrders', 'orders', $options);
    }

    public function getProducts(array $options = [])
    {
        return $this->collectResults('getProducts', 'products', $options);
    }

    public function getProductVariants($productId, $options = [])
    {
        return $this->collectResults('getProductVariant', 'variants', $productId, $options);
    }

    public function getOrderFulfillments($orderId, array $options = [])
    {
        return $this->collectResults('getOrderFulfillments', 'fulfillments', $orderId, $options);
    }

    protected function collectResults()
    {
        $results = [];

        $args = func_get_args();

        $argsCount = func_num_args();

        $API = $args[0];

        $key = $args[1];

        $options = array_slice($args, 2, $argsCount - 2);

        $response = $this->shopify->$API(...$options);

        $body = $response->getBody();

        $results = array_merge($results, $body[$key]);

        $link = $response->getNextLink();

        while ($link) {
            $response = $this->shopify->request('GET', $link);

            $link = $response->getNextLink();

            $results = array_merge($results, $response->getBody()[$key]);
        }

        return $results;
    }
}
