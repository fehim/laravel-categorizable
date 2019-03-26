<?php

namespace hcivelek\Categorizable;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'categorizable');
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'categorizable');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        //register our helpers
        $this->registerHelpers();

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
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/categorizable.php', 'categorizable');

        // Register the service the package provides.
        $this->app->singleton('categorizable', function ($app) {
            return new Categorizable;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['categorizable'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/categorizable.php' => config_path('categorizable.php'),
        ], 'categorizable.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/Resources/views' => base_path('resources/views/vendor/categorizable'),
        ], 'categorizable.views');


        // Publishing assets.
        $this->publishes([
            __DIR__.'/public' => public_path('vendor/categorizable'),
        ], 'categorizable.assets');
        

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/hcivelek'),
        ], 'categorizable.views');*/

        // Registering package commands.
        // $this->commands([]);
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        if (file_exists($file = __DIR__.'/Helper.php'))
        { 
            require $file;
        } 
    }      
}
