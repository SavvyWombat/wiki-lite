<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

/**
 * @uses SavvyWombat\WikiLite\ServiceProvider
 */
class WikiTest extends TestCase
{
    /**
     * @covers SavvyWombat\WikiLite\Controllers\WikiController::welcome
     */
    public function testWelcome()
    {
        $this->get('/wiki')
            ->assertStatus(200)
            ->assertSee('Welcome to WikiLite by SavvyWombat')
            ->assertSee('Let\'s get this wiki started.');

    }
}