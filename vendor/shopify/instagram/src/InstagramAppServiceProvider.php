<?php

namespace Shopify\InstagramApp;

use Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class InstagramAppServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
    public $routeFilePath = '/routes/instagram.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // LOAD THE VIEWS
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/vendor/instagram/base'), 'instagram');
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'instagram');

        // publish views
        $this->publishes([__DIR__.'/resources/views' => base_path('resources/views')], 'views');
        // publish migrations
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');
        // public config
        $this->publishes([__DIR__ . '/config/instagram.php' => config_path('shopify/instagram.php')]);
        // public languages
        $this->publishes([__DIR__.'/resources/lang' => resource_path('lang/vendor/shopify')], 'lang');

        // publish public Instagram assets
        $this->publishes([__DIR__.'/public' => public_path('vendor/shopify/instagram')], 'public');

        // publish config file
        $this->publishes([__DIR__.'/config' => config_path()], 'config');

        $this->mergeConfigFrom(__DIR__ . '/config/shopify/instagram.php', 'shopify.instagram');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        // by default, use the routes file provided in vendor
        $routeFilePathInUse = __DIR__.$this->routeFilePath;

        // but if there's a file with the same name in routes/backpack, use that one
        if (file_exists(base_path().$this->routeFilePath)) {
            $routeFilePathInUse = base_path().$this->routeFilePath;
        }

        $this->loadRoutesFrom($routeFilePathInUse);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupRoutes($this->app->router);
    }
}
