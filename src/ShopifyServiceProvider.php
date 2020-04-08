<?php

namespace Cian\Shopify;

use GuzzleHttp\Client;
use Cian\Shopify\Shopify;
use Cian\Shopify\ShopifyMacro;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class ShopifyServiceProvider extends ServiceProvider implements DeferrableProvider
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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Shopify::class, ShopifyMacro::class];
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
        return new Shopify($client, $config);
    }
}
