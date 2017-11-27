<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

use SavvyWombat\WikiLite\Models\Page;

/**
 * @uses SavvyWombat\WikiLite\Models\Page
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


    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\WikiController::welcome
     */
    public function it_present_the_index_of_pages()
    {
        factory(Page::class)->create();
        $page = Page::first();

        $this->get('/wiki')
            ->assertStatus(200)
            ->assertDontSee('Welcome to WikiLite by SavvyWombat')
            ->assertDontSee('Let\'s get this wiki started.')
            ->assertSee($page->title);
    }
}