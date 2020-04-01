<?php

namespace Cian\Shopify\Services;

use Cian\Shopify\Services\ShopifyService;

class OrderService extends ShopifyService
{
    public function get($orderId, array $options = [])
    {
        return $this->request('GET', "orders/{$orderId}.json", $options);
    }

    public function list(array $options = [])
    {
        return $this->request('GET', 'orders.json', $options);
    }

    public function count(array $options = [])
    {
        return $this->request('GET', 'orders/count.json', $options);
    }

    /**
     * Closes an order
     */
    public function close($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/close.json", $options);
    }

    /**
     * Re-opens a closed order
     */
    public function open($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/open.json", $options);
    }
    
    public function cancel($orderId, array $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/cancel.json", $options);
    }

    public function create($options = [])
    {
        // 
    }

    public function update($orderId)
    {
        // 
    }

    public function delete($orderId)
    {
        // 
    }
}