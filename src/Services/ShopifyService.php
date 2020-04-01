<?php

namespace Cian\Shopify\Services;

use Cian\Shopify\Request;
use Cian\Shopify\Response;
use Cian\Shopify\Exceptions\UnsetWebsiteException;
use Cian\Shopify\Exceptions\UnknownWebsiteException;

abstract class ShopifyService
{
    /**
     * @var \GuzzleHttp\Client $http
     */
    protected $http;

    /**
     * @var array $config
     */
    protected $config;

    /**
     * @var array $options
     */
    protected $options = [];

    /**
     * @var string $website
     */
    protected $website = null;

    /**
     * @var int $retries
     */
    protected $retries;

    public function __construct($http, $config)
    {
        $this->http = $http;

        $this->config = $config;

        $this->setVersion($config['defaults']['api_version']);

        $this->setRetries($config['defaults']['api_retries']);
    }

    public function setRetries($retries)
    {
        $this->retries = $retries;

        return $this->retries;
    }

    public function setWebsite($website)
    {
        if (!isset($this->config['websites'][$website])) {
            throw new UnknownWebsiteException;
        }

        $this->website = $website;

        return $this;
    }

    public function getWebsite()
    {
        $this->website;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setOptions($options = [])
    {
        $this->options = $options;

        return $this;
    }

    public function getConfig()
    {
        if (is_null($this->config)) {
            $this->config = config("shopify.websites.{$this->website}");
        }

        return $this->config;
    }

    public function getCredential()
    {
        return $this->getConfig()['websites'][$this->website]['credential'];
    }

    public function getStoreURL()
    {
        return $this->getConfig()['websites'][$this->website]['url'];
    }

    protected function makeURL($source)
    {
        return "https://{$this->getStoreURL()}/admin/api/{$this->version}/{$source}";
    }

    public function request($method, $source, $options)
    {
        if (is_null($this->website)) {
            throw new UnsetWebsiteException;
        }

        $websiteConfig = $this->config['websites'][$this->website];

        $credential = $websiteConfig['credential'];

        $requestOptions = [
            'auth' => [$credential['key'], $credential['password']]
        ];

        if ($method === 'GET') {
            $requestOptions['query'] = $options;
        } else {
            $requestOptions['json'] = $options;
        }

        $request = new Request($this->http);

        $response = $request->call($method, $this->makeURL($source), $requestOptions, $this->retries);

        return new Response($response);
    }
}
