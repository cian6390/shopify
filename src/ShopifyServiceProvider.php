<?php

namespace Cian\Shopify;

use GuzzleHttp\Client;
use Cian\Shopify\Shopify;
use Cian\Shopify\ShopifyMacro;
use Illuminate\Support\ServiceProvider;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/shopify.php',
            'shopify'
        );
    
        $this->app->bind(Shopify::class, function () {
            return $this->getShopifyInstance();
        });

        $this->app->bind(ShopifyMacro::class, function () {
            return new ShopifyMacro($this->getShopifyInstance());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/shopify.php' => config_path('shopify.php'),
        ], 'config');
    }

    /**
     * Get instance of Shopify
     *
     * @return \Cian\Shopify\Shopify
     */
    public function getShopifyInstance()
    {
        $config = config('shopify');
        $client = app(Client::class);
        $shopify = new Shopify($client, $config);

        if (count($config['websites']) === 1) {
            $firstWebsite = array_keys($config['websites'])[0];
            $shopify->setWebsite($firstWebsite);
        }

        return $shopify;
    }
}
