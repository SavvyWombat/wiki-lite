<?php

namespace SavvyWombat\WikiLite;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * 
     * @codeCoverageIgnore
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/wiki-lite.php' => config_path('wiki-lite.php'),
            __DIR__ . '/../views/_layout.blade.php' => resource_path('views/vendor/savvywombat/wiki-lite/_layout.blade.php'),
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
            __DIR__ . '/../resources/assets/sass/' => resource_path('assets/sass/vendor/savvywombat/wiki-lite'),
            __DIR__ . '/../resources/images/' => public_path('images/vendor/savvywombat/wiki-lite'),
        ]);


        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');


        $this->loadRoutesFrom(__DIR__ . '/../routes/wiki-lite.php');


        $this->loadViewsFrom(__DIR__ . '/../views', 'savvywombat/wiki-lite');
    }
}