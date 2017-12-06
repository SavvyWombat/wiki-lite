<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

use SavvyWombat\WikiLite\Models\Page;

/**
 * @uses SavvyWombat\WikiLite\Models\Page
 * @uses SavvyWombat\WikiLite\ServiceProvider
 * @uses \wikilink
 */
class PageTest extends TestCase
{
    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::view
     * @uses \wikilinks
     * @uses \wikilink
     */
    public function it_presents_the_requested_page()
    {
        $page = factory(Page::class)->create();

        $this->get("/wiki/view/{$page->slug}")
            ->assertStatus(200)
            ->assertSee($page->title)
            ->assertSee($page->content);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::view
     * @uses \wikilinks
     * @uses \wikilink
     */
    public function it_presents_a_404_for_missing_pages()
    {
        $this->get('/wiki/view/this-is-not-a-page')
            ->assertStatus(404)
            ->assertSee('Not found')
            ->assertSee('"this-is-not-a-page" doesn\'t seem to exist. Create a new page?');
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::view
     * @covers SavvyWombat\WikiLite\Models\Page::pages
     * @uses \wikilinks
     * @uses \wikilink
     */
    public function it_lists_subpages()
    {
        $parent = factory(Page::class)->create();

        $child = factory(Page::class)->make();
        $child->parent_uuid = $parent->uuid;
        $child->save();

        $this->get("/wiki/view/{$parent->slug}")
            ->assertStatus(200)
            ->assertSee($parent->title)
            ->assertSee($parent->content)
            ->assertSee($child->title)
            ->assertDontSee($child->content);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::view
     * @covers SavvyWombat\WikiLite\Models\Page::parent
     * @uses \wikilinks
     * @uses \wikilink
     */
    public function it_lists_parents()
    {
        $grandparent = factory(Page::class)->create();

        $parent = factory(Page::class)->make();
        $parent->parent_uuid = $grandparent->uuid;
        $parent->save();

        $child = factory(Page::class)->make();
        $child->parent_uuid = $parent->uuid;
        $child->save();

        $this->get("/wiki/view/{$child->slug}")
            ->assertStatus(200)
            ->assertSee("WikiLite")
            ->assertSee($grandparent->title)
            ->assertDontSee($grandparent->content)
            ->assertSee($parent->title)
            ->assertDontSee($parent->content)
            ->assertSee($child->title)
            ->assertSee($child->content);
    }



    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function it_saves_a_new_page_and_redirects()
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
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function it_creates_a_new_revision_with_the_same_uuid_and_redirects()
    {
        $existingPage = factory(Page::class)->create();

        $this->post('/wiki/save', [
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
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @covers SavvyWombat\WikiLite\Requests\SavePage::rules
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function it_returns_errors_when_missing_required_content()
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

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::edit
     */
    public function it_loads_existing_data_in_the_edit_form()
    {
        $page = factory(Page::class)->create();

        $this->get("/wiki/edit/{$page->slug}")
            ->assertStatus(200)
            ->assertSee("Editing " . $page->title)
            ->assertSee($page->title)
            ->assertSee($page->content);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::edit
     */
    public function it_loads_an_empty_form_when_creating_new_page()
    {
        $this->get("/wiki/edit")
            ->assertStatus(200)
            ->assertSee("Creating new page");
    }
}