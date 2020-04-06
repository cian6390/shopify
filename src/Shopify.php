<?php

namespace Cian\Shopify;

use Cian\Shopify\ShopifyService;

class Shopify extends ShopifyService
{
    public function getOrder($orderId, array $options = [])
    {
        return $this->request('GET', "orders/{$orderId}.json", $options);
    }

    public function listOrders(array $options = [])
    {
        return $this->request('GET', 'orders.json', $options);
    }

    public function countOrder(array $options = [])
    {
        return $this->request('GET', 'orders/count.json', $options);
    }

    /**
     * Closes an order
     */
    public function closeOrder($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/close.json", $options);
    }

    /**
     * Re-opens a closed order
     */
    public function openOrder($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/open.json", $options);
    }

    public function cancelOrder($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/cancel.json", $options);
    }

    public function createOrder(array $options)
    {
        return $this->request('POST', "orders.json", $options);
    }

    public function updateOrder($orderId, array $options)
    {
        return $this->request('PUT', "orders/{$orderId}.json", $options);
    }

    public function deleteOrder($orderId)
    {
        return $this->request('DELETE', "orders/{$orderId}.json");
    }
}