<?php

namespace Cian\Shopify;

use Cian\Shopify\ShopifyService;

class Shopify extends ShopifyService
{
    /**
     * @return \Cian\Shopify\Response
     */
    public function getOrder($orderId, array $options = [])
    {
        return $this->request('GET', "orders/{$orderId}.json", $options);
    }

    /**
     * @return \Cian\Shopify\Response
     */
    public function listOrders(array $options = [])
    {
        return $this->request('GET', 'orders.json', $options);
    }

    /**
     * @return \Cian\Shopify\Response
     */
    public function countOrder(array $options = [])
    {
        return $this->request('GET', 'orders/count.json', $options);
    }

    /**
     * Closes an order
     * 
     * @return \Cian\Shopify\Response
     */
    public function closeOrder($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/close.json", $options);
    }

    /**
     * Re-opens a closed order
     * 
     * @return \Cian\Shopify\Response
     */
    public function openOrder($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/open.json", $options);
    }

    /**
     * @return \Cian\Shopify\Response
     */
    public function cancelOrder($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/cancel.json", $options);
    }

    /**
     * @return \Cian\Shopify\Response
     */
    public function createOrder(array $options)
    {
        return $this->request('POST', "orders.json", $options);
    }

    /**
     * @return \Cian\Shopify\Response
     */
    public function updateOrder($orderId, array $options = [])
    {
        return $this->request('PUT', "orders/{$orderId}.json", $options);
    }

    /**
     * @return \Cian\Shopify\Response
     */
    public function deleteOrder($orderId)
    {
        return $this->request('DELETE', "orders/{$orderId}.json");
    }

    /**
     * Retrieves a list of products.
     * 
     * @return \Cian\Shopify\Response
     */
    public function getProducts($options = [])
    {
        return $this->request('GET', 'products.json', $options);
    }

    /**
     * Retrieves a single product.
     * 
     * @return \Cian\Shopify\Response
     */
    public function getProduct($productId, $options = [])
    {
        return $this->request('GET', "products/$productId.json", $options);
    }

    /**
     * Creates a new product.
     * 
     * @return \Cian\Shopify\Response
     */
    public function createProduct(array $product)
    {
        return $this->request('POST', "products.json", ['product' => $product]);
    }

    /**
     * Retrieves a single product variant by ID.
     * 
     * @return \Cian\Shopify\Response
     */
    public function getProductVariant($variantId, $options = [])
    {
        return $this->request('GET', "variants/$variantId.json", $options);
    }

    /**
     * Updates an existing product variant.
     * 
     * @return \Cian\Shopify\Response
     */
    public function updateProductVariant($variantId, $variant = [])
    {
        return $this->request('PUT', "variants/$variantId.json", ['variant' => $variant]);
    }
}