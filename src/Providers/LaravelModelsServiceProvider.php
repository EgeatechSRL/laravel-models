<?php

namespace EgeaTech\LaravelModels\Providers;

use Illuminate\Support\ServiceProvider;
use EgeaTech\LaravelModels\LaravelModels;

class LaravelModelsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the service the package provides.
        $this->app->singleton('laravel-models', function ($app) {
            return new LaravelModels;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['laravel-models'];
    }
}
