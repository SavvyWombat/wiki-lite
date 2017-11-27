<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

/**
 * @uses SavvyWombat\WikiLite\ServiceProvider
 */
class WikiTest extends TestCase
{
    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\WikiController::welcome
     */
    public function it_presents_the_welcome_page_when_no_pages_saved()
    {
        $this->get('/wiki')
            ->assertStatus(200)
            ->assertSee('Welcome to WikiLite by SavvyWombat')
            ->assertSee('Let\'s get this wiki started.');
    }
}