<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends BaseTestCase
{
    // Refreshes the database between tests
    use RefreshDatabase;

    /**
     * The base url to use for testing
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';



    public function setup()
    {
        parent::setup();

        $this->artisan('migrate', [
            '--database' => 'testing',
        ]);

        $this->withFactories(__DIR__ . '/../../database/factories');
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('wiki-lite',
            require __DIR__ . '/../../config/wiki-lite.php'
        );

        $app['config']->set('database.default',
            'testing'
        );

        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'SavvyWombat\WikiLite\ServiceProvider',
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            // No facades yet
        ];
    }
}