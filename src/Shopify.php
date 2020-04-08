<?php

namespace Cian\Shopify;

use Cian\Shopify\ShopifyService;

class Shopify extends ShopifyService
{
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
    public function listOrders(array $options = [])
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
    public function cancelOrder($orderId)
    {
        return $this->request('POST', "orders/{$orderId}/cancel.json");
    }

    /**
     * Creates an order.
     *
     * @return Response
     */
    public function createOrder(array $order)
    {
        return $this->request('POST', 'orders.json', ['order' => $order]);
    }

    /**
     * @return Response
     */
    public function updateOrder($orderId, array $order = [])
    {
        return $this->request('PUT', "orders/{$orderId}.json", ['order' => $order]);
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
     * Creates a new product.
     *
     * @return Response
     */
    public function createProduct(array $product)
    {
        return $this->request('POST', 'products.json', ['product' => $product]);
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
    public function updateProductVariant($variantId, $variant = [])
    {
        return $this->request('PUT', "variants/$variantId.json", ['variant' => $variant]);
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
    public function createOrderFulfillment($orderId, array $fulfillment)
    {
        return $this->request('POST', "orders/$orderId/fulfillments.json", ['fulfillment' => $fulfillment]);
    }

    /**
     * Update information associated with a fulfillment.
     *
     * @return Response
     */
    public function updateOrderFulfillment($orderId, $fulfillmentId, array $fulfillment)
    {
        return $this->request('PUT', "orders/$orderId/fulfillments/$fulfillmentId.json", ['fulfillment' => $fulfillment]);
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
        return $this->request('POST', "draft_orders.json", $options);
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
    public function listDraftOrder(array $options = [])
    {
        return $this->request('GET', "draft_orders.json", $options);
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
        return $this->request('GET', "draft_orders/count.json", $options);
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
     * Retrieves a list of all order risks for an order.
     *
     * @param $orderId
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function listOrderRisks($orderId)
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
     * Retrieves a list of transactions.
     *
     * @param $orderId
     * @param array $options
     * @return Response
     * @throws Exceptions\UnsetWebsiteException
     */
    public function listOrderTransactions($orderId, array $options = [])
    {
        return $this->request('GET', "orders/{$orderId}/transactions.json", $options);
    }
}
