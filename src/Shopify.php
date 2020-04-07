<?php

namespace Cian\Shopify;

use Cian\Shopify\ShopifyService;

class Shopify extends ShopifyService
{
    /**
     * Retrieves a specific order.
     * 
     * @return \Cian\Shopify\Response
     */
    public function getOrder($orderId, array $options = [])
    {
        return $this->request('GET', "orders/{$orderId}.json", $options);
    }

    /**
     * Retrieves a list of orders.
     * 
     * @return \Cian\Shopify\Response
     */
    public function listOrders(array $options = [])
    {
        return $this->request('GET', 'orders.json', $options);
    }

    /**
     * Retrieves an order count.
     * 
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
    public function closeOrder($orderId)
    {
        return $this->request('POST', "orders/{$orderId}/close.json");
    }

    /**
     * Re-opens a closed order
     *
     * @return \Cian\Shopify\Response
     */
    public function openOrder($orderId)
    {
        return $this->request('POST', "orders/{$orderId}/open.json");
    }

    /**
     * Cancels an order. Orders that have a fulfillment object can't be canceled.
     * 
     * @return \Cian\Shopify\Response
     */
    public function cancelOrder($orderId)
    {
        return $this->request('POST', "orders/{$orderId}/cancel.json");
    }

    /**
     * Creates an order.
     * 
     * @return \Cian\Shopify\Response
     */
    public function createOrder(array $order)
    {
        return $this->request('POST', 'orders.json', ['order' => $order]);
    }

    /**
     * @return \Cian\Shopify\Response
     */
    public function updateOrder($orderId, array $order = [])
    {
        return $this->request('PUT', "orders/{$orderId}.json", ['order' => $order]);
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
        return $this->request('POST', 'products.json', ['product' => $product]);
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

    /**
     * Retrieves fulfillments associated with an order.
     *
     * @return \Cian\Shopify\Response
     */
    public function getOrderFulfillments($orderId, array $options = [])
    {
        return $this->request('GET', "orders/$orderId/fulfillments.json", $options);
    }

    /**
     * Create a fulfillment for the specified order and line items.
     *
     * @return \Cian\Shopify\Response
     */
    public function createOrderFulfillment($orderId, array $fulfillment)
    {
        return $this->request('POST', "orders/$orderId/fulfillments.json", ['fulfillment' => $fulfillment]);
    }

    /**
     * Update information associated with a fulfillment.
     *
     * @return \Cian\Shopify\Response
     */
    public function updateOrderFulfillment($orderId, $fulfillmentId, array $fulfillment)
    {
        return $this->request('PUT', "orders/$orderId/fulfillments/$fulfillmentId.json", ['fulfillment' => $fulfillment]);
    }

    /**
     * Cancel a fulfillment for a specific order ID.
     *
     * @return \Cian\Shopify\Response
     */
    public function cancelOrderFullment($orderId, $fulfillmentId)
    {
        return $this->request('POST', "orders/$orderId/fulfillments/$fulfillmentId/cancel.json");
    }
}
