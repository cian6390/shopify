<?php

use GuzzleHttp\Client;
use Cian\Shopify\Shopify;
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

        foreach ($this->provides() as $abstract) {
            $this->app->bind($abstract, $this->getInstance);
        }
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
        return [Shopify::class, 'shopify'];
    }

    /**
     * Get instance of Shopify
     *
     * @return \Cian\Shopify\Shopify
     */
    public function getInstance()
    {
        $config = config('shopify');
        $client = app(Client::class);
        return app(Shopify::class, ['http' => $client, 'config' => $config]);
    }
}
