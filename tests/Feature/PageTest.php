<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

use SavvyWombat\WikiLite\Models\Page;

/**
 * @uses SavvyWombat\WikiLite\Models\Page
 * @uses SavvyWombat\WikiLite\ServiceProvider
 */
class PageTest extends TestCase
{
    /**
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function testSave()
    {
        $this->post('/wiki/save', [
                'content' => 'Some content for our fresh new page',
                'title' => 'Fresh new wiki page',
            ])
            ->assertStatus(302)
            ->assertRedirect('/wiki/view/fresh-new-wiki-page');

        $page = Page::first();

        $this->assertDatabaseHas('wiki_lite_pages', [
            'content' => 'Some content for our fresh new page',
            'title' => 'Fresh new wiki page',
            'slug' => 'fresh-new-wiki-page',
        ]);
    }

    /**
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @covers SavvyWombat\WikiLite\Requests\SavePage::rules
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function testSave_ensureRequiredContent()
    {
        $this->post('/wiki/save')
            ->assertStatus(302)
            ->assertRedirect('/wiki/edit')
            ->assertSessionHasErrors(['title', 'content']);

        $this->post('/wiki/save', [
                'content' => '',
                'title' => '',
            ])
            ->assertRedirect('/wiki/edit')
            ->assertSessionHasErrors(['title', 'content']);
    }
}