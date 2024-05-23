<?php

namespace GuideMaster\LaravelWoocommerce;

use Illuminate\Support\ServiceProvider;

class LaravelWoocommerceServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'guidemaster');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'guidemaster');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-woocommerce.php', 'laravel-woocommerce');

        // Register the service the package provides.
        $config = $this->app['config']->get('laravel-woocommerce');
        $this->app->singleton('laravel-woocommerce.client', function() use ($config) {
            return new Client(
                $config['store_url'],
                $config['consumer_key'],
                $config['consumer_secret'],
                [
                    'version' => 'wc/'.$config['api_version'],
                    'verify_ssl' => $config['verify_ssl'],
                    'wp_api' => $config['wp_api'],
                    'query_string_auth' => $config['query_string_auth'],
                    'timeout' => $config['timeout'],
                ]);
        });

        $this->app->singleton('laravel-woocommerce', function ($app) {
            return new LaravelWoocommerce;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-woocommerce'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-woocommerce.php' => config_path('laravel-woocommerce.php'),
        ], 'laravel-woocommerce.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/guidemaster'),
        ], 'laravel-woocommerce.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/guidemaster'),
        ], 'laravel-woocommerce.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/guidemaster'),
        ], 'laravel-woocommerce.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
