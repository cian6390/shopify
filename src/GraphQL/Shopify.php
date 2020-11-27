<?php

namespace Cian\Shopify\GraphQL;
use Closure;

class Shopify
{
    /**
     * @var \GuzzleHttp\Client $http
     */
    protected $http;

    /**
     * @var string $domain
     */
    protected $domain;

    /**
     * @var string $password
     */
    protected $password;

    public function __construct($http, $options)
    {
        $this->http = $http;
        $this->domain = $options['domain'];
        $this->password = $options['password'];
    }

    public function getOrderRisk($orderId)
    {
        $query = <<<'GRAPHQL'
        {
            order(id: "gid://shopify/Order/__ORDER_ID__") {
                riskLevel
                risks {
                    display
                    level
                    message
                }
            }
        }
        GRAPHQL;
        $query = str_replace('__ORDER_ID__', $orderId, $query);
        $response = $this->request($query);
        dd($response->getBody()->getContents());
    }

    public function getOrder($orderId, array $options = [])
    {
        $variables = [];
        $query = <<<'GRAPHQL'
        {
            order(id: "gid://shopify/Order/__ORDER_ID__") {
                id
                totalPrice
                billingAddress {
                    address1
                    address2
                    city
                    company
                    country
                    firstName
                    lastName
                    name
                    phone
                    zip
                    province
                    provinceCode
                    latitude
                    longitude
                    countryCodeV2
                }
                cancelledAt
                closedAt
                closed
                currencyCode
                currentCartDiscountAmountSet {
                      presentmentMoney {
                        amount
                        currencyCode
                    }
                    shopMoney {
                        amount
                        currencyCode
                    }
                }
                riskLevel
                risks {
                    display
                    level
                    message
                }
                taxLines {
                    rate
                    ratePercentage
                    title
                }
                customer {
                    id
                    createdAt
                    defaultAddress {
                        address1
                        address2
                        city
                        company
                        country
                        firstName
                        lastName
                        name
                        phone
                        zip
                        province
                        provinceCode
                        latitude
                        longitude
                        countryCodeV2
                    }
                    displayName
                    email
                    firstName
                    lastName
                    note
                    phone
                    tags
                    updatedAt
                    validEmailAddress
                    verifiedEmail
                }
                lineItems (first: 100){
                    edges {
                        node {
                            id
                            sku
                            title
                            quantity
                            image {
                                altText
                                originalSrc
                            }
                        }
                    }
                }
            }
        }
        GRAPHQL;
        $query = str_replace('__ORDER_ID__', $orderId, $query);
        $response = $this->request($query, $variables);
        dd(json_decode($response->getBody()->getContents(), true));

        // formate before return
    }

    private function request($query, $variables = [])
    {
        return $this->http->request('POST', 'https://' . $this->domain . '/admin/api/2020-10/graphql.json', [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Shopify-Access-Token' => $this->password,
            ],
            'body' => json_encode([
                'query' => $query
            ])
        ]);
    }
}