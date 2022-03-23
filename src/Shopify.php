<?php

namespace Cian\Shopify;

use Cian\Shopify\ShopifyService;

class Shopify extends ShopifyService
{
    /**
     * Create a new Webhook.
     *
     * @return Response
     */
    public function createWebhook(array $options = [])
    {
        return $this->request('POST', 'webhooks.json', $options);
    }

    /**
     * Retrieves a list of webhooks.
     *
     * @return Response
     */
    public function getWebhooks(array $options = [])
    {
        return $this->request('GET', 'webhooks.json', $options);
    }

    /**
     * Retrieves a single webhook.
     *
     * @return Response
     */
    public function getWebhook($webhookId, array $options = [])
    {
        return $this->request('GET', "webhooks/{$webhookId}.json", $options);
    }

    /**
     * Revice a count of all Webhooks.
     *
     * @return Response
     */
    public function getWebhookCount(array $options = [])
    {
        return $this->request('GET', 'webhooks/count.json', $options);
    }

    /**
     * Update an existing Webhook.
     *
     * @return Response
     */
    public function updateWebhook($webhookId, array $options = [])
    {
        return $this->request('PUT', "webhooks/{$webhookId}.json", $options);
    }

    /**
     * Remove an existing Webhook.
     *
     * @return Response
     */
    public function deleteWebhook($webhookId, array $options = [])
    {
        return $this->request('DELETE', "webhooks/{$webhookId}.json", $options);
    }

    /**
     * Retrieves a specific order.
     *
     * @return Response
     */
    public function getOrder($orderId, array $options = [])
    {
        return $this->request('GET', "orders/{$orderId}.json", $options);
    }

    /**
     * Retrieves a list of orders.
     *
     * @return Response
     */
    public function getOrders(array $options = [])
    {
        return $this->request('GET', 'orders.json', $options);
    }

    /**
     * Retrieves an order count.
     *
     * @return Response
     */
    public function countOrder(array $options = [])
    {
        return $this->request('GET', 'orders/count.json', $options);
    }

    /**
     * Closes an order
     *
     * @return Response
     */
    public function closeOrder($orderId)
    {
        return $this->request('POST', "orders/{$orderId}/close.json");
    }

    /**
     * Re-opens a closed order
     *
     * @return Response
     */
    public function openOrder($orderId)
    {
        return $this->request('POST', "orders/{$orderId}/open.json");
    }

    /**
     * Cancels an order. Orders that have a fulfillment object can't be canceled.
     *
     * @return Response
     */
    public function cancelOrder($orderId, $options = [])
    {
        return $this->request('POST', "orders/{$orderId}/cancel.json", $options);
    }

    /**
     * Creates an order.
     *
     * @return Response
     */
    public function createOrder(array $options)
    {
        return $this->request('POST', 'orders.json', $options);
    }

    /**
     * @return Response
     */
    public function updateOrder($orderId, array $options = [])
    {
        return $this->request('PUT', "orders/{$orderId}.json", $options);
    }

    /**
     * @return Response
     */
    public function deleteOrder($orderId)
    {
        return $this->request('DELETE', "orders/{$orderId}.json");
    }

    /**
     * Retrieves a list of products.
     *
     * @return Response
     */
    public function getProducts($options = [])
    {
        return $this->request('GET', 'products.json', $options);
    }

    /**
     * Retrieves a single product.
     *
     * @return Response
     */
    public function getProduct($productId, $options = [])
    {
        return $this->request('GET', "products/$productId.json", $options);
    }

    /**
     * Retrieves a list of product variants.
     *
     * @return Response
     */
    public function getProductVariants($productId, $options = [])
    {
        return $this->request('GET', "products/$productId/variants.json", $options);
    }

    /**
     * Creates a new product.
     *
     * @return Response
     */
    public function createProduct(array $options)
    {
        return $this->request('POST', 'products.json', $options);
    }

    /**
     * Retrieves a single product variant by ID.
     *
     * @return Response
     */
    public function getProductVariant($variantId, $options = [])
    {
        return $this->request('GET', "variants/$variantId.json", $options);
    }

    /**
     * Updates an existing product variant.
     *
     * @return Response
     */
    public function updateProductVariant($variantId, $options = [])
    {
        return $this->request('PUT', "variants/$variantId.json", $options);
    }

    /**
     * Retrieves fulfillments associated with an order.
     *
     * @return Response
     */
    public function getOrderFulfillments($orderId, array $options = [])
    {
        return $this->request('GET', "orders/$orderId/fulfillments.json", $options);
    }

    /**
     * Create a fulfillment for the specified order and line items.
     *
     * @return Response
     */
    public function createOrderFulfillment($orderId, array $options)
    {
        return $this->request('POST', "orders/$orderId/fulfillments.json", $options);
    }

    /**
     * Update information associated with a fulfillment.
     *
     * @return Response
     */
    public function updateOrderFulfillment($orderId, $fulfillmentId, array $options)
    {
        return $this->request('PUT', "orders/$orderId/fulfillments/$fulfillmentId.json", $options);
    }

    /**
     * Cancel a fulfillment for a specific order ID.
     *
     * @return Response
     */
    public function cancelOrderFullment($orderId, $fulfillmentId)
    {
        return $this->request('POST', "orders/$orderId/fulfillments/$fulfillmentId/cancel.json");
    }

    /**
     * Creates a draft order.
     *
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function createDraftOrder(array $options)
    {
        return $this->request('POST', 'draft_orders.json', $options);
    }

    /**
     * Updates a draft order.
     *
     * @param $draftOrderId
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function updateDraftOrder($draftOrderId, array $options)
    {
        return $this->request('PUT', "draft_orders/{$draftOrderId}.json", $options);
    }

    /**
     * Retrieves a list of draft orders.
     *
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function getDraftOrders(array $options = [])
    {
        return $this->request('GET', 'draft_orders.json', $options);
    }

    /**
     * Retrieves a specific draft order
     *
     * @param $draftOrderId
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function getDraftOrder($draftOrderId, array $options = [])
    {
        return $this->request('GET', "draft_orders/{$draftOrderId}.json", $options);
    }

    /**
     * Retrieves a count of draft orders.
     *
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function countDraftOrder(array $options = [])
    {
        return $this->request('GET', 'draft_orders/count.json', $options);
    }

    /**
     * Sends an invoice for the draft order.
     *
     * @param $draftOrderId
     * @param $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function createDraftOrderInvoice($draftOrderId, $options)
    {
        return $this->request('POST', "draft_orders/{$draftOrderId}/send_invoice.json", $options);
    }

    /**
     * Deletes a draft order
     *
     * @param $draftOrderId
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function deleteDraftOrder($draftOrderId)
    {
        return $this->request('DELETE', "draft_orders/{$draftOrderId}.json");
    }

    /**
     * Completes a draft order.
     *
     * @param $draftOrderId
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function completeDraftOrder($draftOrderId, array $options = [])
    {
        return $this->request('PUT', "draft_orders/{$draftOrderId}/complete.json", $options);
    }

    /**
     * Retrieves a list of customers.
     *
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function getCustomers(array $options = [])
    {
        return $this->request('GET', 'customers.json', $options);
    }

    /**
     * Retrieves a single customer.
     *
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function getCustomer($customerId)
    {
        return $this->request('GET', "customers/{$customerId}.json");
    }

    /**
     * Retrieves a single customer.
     *
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function searchMetafields($params = [])
    {
        $querystring = '';

        if (!empty($params)) {
            $items = [];
            foreach ($params as $key => $value) {
                $items[] = "metafield[{$key}]={$value}";
            }

            $querystring = '?' . implode('&', $items);
        }

        return $this->request('GET', 'metafields.json' . $querystring);
    }

    /**
     * Searches for customers that match a supplied query.
     *
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function searchCustomers(array $options)
    {
        return $this->request('GET', 'customers/search.json', $options);
    }

    /**
     * Creates a customer.
     *
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function createCustomer(array $options)
    {
        return $this->request('POST', 'customers.json', $options);
    }

    /**
     * Updates a customer.
     *
     * @param int $customerId
     * @param array $options.
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function updateCustomer($customerId, array $options)
    {
        return $this->request('PUT', "customers/{$customerId}.json", $options);
    }

    /**
     * Retrieves a list of inventory levels.
     *
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function getInventoryLevels(array $options = [])
    {
        return $this->request('GET', 'inventory_levels.json', $options);
    }

    /**
     * Retrieves a list of locations.
     *
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function getLocations()
    {
        return $this->request('GET', 'locations.json');
    }

    /**
     * Retrieves a list of all order risks for an order.
     *
     * @param $orderId
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function getOrderRisks($orderId)
    {
        return $this->request('GET', "orders/{$orderId}/risks.json");
    }

    /**
     * Creates a refund.
     *
     * @param $orderId
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function createOrderRefund($orderId, array $options)
    {
        return $this->request('POST', "orders/{$orderId}/refunds.json", $options);
    }

    /**
     * Calculate a refund.
     *
     * @param $orderId
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function calculateOrderRefund($orderId, array $options)
    {
        return $this->request('POST', "orders/{$orderId}/refunds/calculate.json", $options);
    }

    /**
     * Retrieves a list of transactions.
     *
     * @param $orderId
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function getOrderTransactions($orderId, array $options = [])
    {
        return $this->request('GET', "orders/{$orderId}/transactions.json", $options);
    }
}
