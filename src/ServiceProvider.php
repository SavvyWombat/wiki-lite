<?php

namespace SavvyWombat\WikiLite;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/wiki-lite.php' => config_path('wiki-lite.php'),
            __DIR__ . '/../views/layout.blade.php' => resource_path('views/vendor/wiki-lite/layout.blade.php'),
        ]);


        $this->loadRoutesFrom(__DIR__ . '/../routes/wiki-lite.php');


        $this->loadViewsFrom(__DIR__ . '/../views', 'wiki-lite');
    }
}