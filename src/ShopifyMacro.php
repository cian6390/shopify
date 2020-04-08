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

    protected function collectResults($API, $key, $options)
    {
        $results = [];

        $response = $this->shopify->$API($options);

        $body = $response->getBody();

        $results = array_merge($results, $body[$key]);

        $link = $response->getNextLink();

        while ($link = $response->getNextLink()) {

            $response = $this->shopify->request('GET', $link);

            $results = array_merge($results, $response->getBody()[$key]);
        }

        return $results;
    }
}
