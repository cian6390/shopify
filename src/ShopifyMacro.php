<?php

namespace Cian\Shopify;

use Closure;
use Cian\Shopify\Shopify;
use Cian\Shopify\Exceptions\UnknownWebsiteException;

class ShopifyMacro
{
    protected $shopify;

    /**
     * @var Closure|null $formatter
     */
    protected $formatter = null;

    public function __construct(Shopify $shopify)
    {
        $this->shopify = $shopify;
    }

    /**
     * @param \Closure $formatter
     * 
     * @return $this
     */
    public function setFormatter($formatter = null)
    {
        $this->formatter = Closure::bind($formatter, null);

        return $this;
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

    public function getCustomers(array $options = [])
    {
        return $this->collectResults('getCustomers', 'customers', $options);
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

        $useFormatter = !is_null($this->formatter);

        $nextLink = null;

        do {
            if ($nextLink) {
                $response = $this->shopify->request('GET', $nextLink);
            } else {
                $response = $this->shopify->$API(...$options);
            }

            $items = $response->getBody()[$key];

            foreach ($items as $item) {
                $results[] = $useFormatter ? ($this->formatter)($item) : $item;
            }

            $nextLink = $response->getNextLink();

        } while ($nextLink);

        return $results;
    }
}
