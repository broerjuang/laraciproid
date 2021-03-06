<?php

namespace Matriphe\Laraciproid;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        if (version_compare(app()->version(), '5.0', '>=')) {
            $this->publishes([
                __DIR__.'/config/config.php' => config_path('laraciproid.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/database/migrations/' => database_path('migrations'),
            ], 'migrations');

            $this->publishes([
                __DIR__.'/database/seeds/' => database_path('seeds'),
            ], 'seeds');
            
            $this->publishes([
                __DIR__.'/database/sql/' => database_path('sql'),
            ], 'sql');

            $this->publishes([
                __DIR__.'/models/' => app_path('Models'),
            ], 'models');

            $this->publishes([
                __DIR__.'/database/json/' => database_path('json'),
            ], 'json');
        }
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        if (version_compare(app()->version(), '5.0', '>=')) {
            $this->registerSkeleton();

            $this->mergeConfigFrom(
                __DIR__.'/config/config.php', 'laraciproid'
            );

            config([
                'config/laraciproid.php',
            ]);
        }
    }

    private function registerSkeleton()
    {
        $this->app->bind('laraciproid', function ($app) {
            return new Laraciproid($app);
        });
    }
}
