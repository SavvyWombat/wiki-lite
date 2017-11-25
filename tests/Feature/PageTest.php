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
    public function testSave_newPage()
    {
        $this->post('/wiki/save', [
                'content' => 'Some content for our fresh new page',
                'title' => 'Fresh new wiki page',
            ])
            ->assertStatus(302)
            ->assertRedirect('/wiki/view/fresh-new-wiki-page');

        $this->assertDatabaseHas('wiki_lite_pages', [
            'content' => 'Some content for our fresh new page',
            'title' => 'Fresh new wiki page',
            'slug' => 'fresh-new-wiki-page',
        ]);
    }

    /**
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function testSave_existingPage()
    {
        factory(Page::class)->create();
        $existingPage = Page::first();

        $response = $this->post('/wiki/save', [
                'uuid' => $existingPage->uuid,
                'content' => 'Changed the content',
                'title' => 'Changed the title',
            ])
            ->assertStatus(302)
            ->assertRedirect('/wiki/view/changed-the-title');

        // original version remains unchanged
        $this->assertDatabaseHas('wiki_lite_pages', [
            'revision' => '1',
            'uuid' => $existingPage->uuid,
            'content' => $existingPage->content,
            'title' => $existingPage->title,
        ]);

        // new version exists
        $this->assertDatabaseHas('wiki_lite_pages', [
            'revision' => '2',
            'uuid' => $existingPage->uuid,
            'content' => 'Changed the content',
            'title' => 'Changed the title',
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