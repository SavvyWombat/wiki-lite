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
            __DIR__ . '/../config/wikilite.php' => config_path('wikilite.php'),
        ]);


        $this->loadRoutesFrom(__DIR__ . '/../routes/wikilite.php');


        $this->loadViewsFrom(__DIR__ . '/../views', 'wikilite');
    }
}