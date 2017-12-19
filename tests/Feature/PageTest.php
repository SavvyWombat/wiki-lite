<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

use SavvyWombat\WikiLite\Models\LinkBack;
use SavvyWombat\WikiLite\Models\Page;

/**
 * @uses SavvyWombat\WikiLite\Models\LinkBack
 * @uses SavvyWombat\WikiLite\Models\Page
 * @uses SavvyWombat\WikiLite\Rules\Slug
 * @uses SavvyWombat\WikiLite\ServiceProvider
 * @uses \wikilinks
 * @uses \wikilink
 */
class PageTest extends TestCase
{
    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::view
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
     */
    public function it_gets_the_latest_revision_of_the_page()
    {
        $firstRevision = factory(Page::class)->create();

        $secondRevision = factory(Page::class)->make();
        $secondRevision->uuid = $firstRevision->uuid;
        $secondRevision->title = $firstRevision->title;
        $secondRevision->save();

        $this->get("/wiki/view/{$firstRevision->slug}")
            ->assertStatus(200)
            ->assertSee($firstRevision->title)
            ->assertSee($secondRevision->content);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::view
     */
    public function it_gets_the_latest_revision_of_the_page_for_an_old_slug()
    {
        $firstRevision = factory(Page::class)->create();

        $secondRevision = factory(Page::class)->make();
        $secondRevision->uuid = $firstRevision->uuid;
        $secondRevision->save();

        $this->get("/wiki/view/{$firstRevision->slug}")
            ->assertStatus(200)
            ->assertSee($secondRevision->title)
            ->assertSee($secondRevision->content);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::view
     */
    public function it_gets_newest_page_with_the_same_slug()
    {
        $firstPage = factory(Page::class)->create();

        $secondPage = factory(Page::class)->make();
        $secondPage->title = $firstPage->title;
        $secondPage->save();

        $this->get("/wiki/view/{$firstPage->slug}")
            ->assertStatus(200)
            ->assertSee($secondPage->content)
            ->assertDontSee($firstPage->content);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::view
     */
    public function it_gets_the_list_of_link_backs()
    {
        $sourcePage = factory(Page::class)->create();

        $targetPage = factory(Page::class)->create();

        $linkBack = factory(LinkBack::class)->make();
        $linkBack->target_slug = $targetPage->slug;
        $linkBack->source_uuid = $sourcePage->uuid;
        $linkBack->save();

        $this->get("/wiki/view/{$targetPage->slug}")
            ->assertStatus(200)
            ->assertSee("Pages which link back to this one")
            ->assertSee(sprintf('<a href="http://localhost/wiki/view/%s">%s</a>',
                $sourcePage->slug,
                $sourcePage->title
            ));
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
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @covers SavvyWombat\WikiLite\Requests\SavePage::rules
     * @covers SavvyWombat\WikiLite\Rules\Slug::passes
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function it_returns_errors_if_an_existing_title_is_used()
    {
        $firstPage = factory(Page::class)->create();

        $this->post('/wiki/save', [
            'content' => 'stuff',
            'title' => $firstPage->title,
        ])
        ->assertRedirect('/wiki/edit')
        ->assertSessionHasErrors(['title']);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @covers SavvyWombat\WikiLite\Requests\SavePage::rules
     * @covers SavvyWombat\WikiLite\Rules\Slug::passes
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function it_returns_errors_if_similar_titles_have_same_slug()
    {
        $firstPage = factory(Page::class)->make();
        $firstPage->title = "Punctuation doesn't exist in slugs";
        $firstPage->save();

        $this->post('/wiki/save', [
            'content' => 'stuff',
            'title' => "punctuation. doesnt exist in slugs",
        ])
        ->assertRedirect('/wiki/edit')
        ->assertSessionHasErrors(['title']);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @covers SavvyWombat\WikiLite\Models\Page::saving
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function it_saves_the_links_in_the_linkback_table()
    {
        $page = factory(Page::class)->create();

        $this->post('/wiki/save', [
                'uuid' => $page->uuid,
                'title' => 'This page has links',
                'content' => 'This [[links to somewhere else]] and [[to here, too]]',
            ])
            ->assertStatus(302)
            ->assertRedirect('/wiki/view/this-page-has-links');

        $this->assertDatabaseHas('wiki_lite_linkbacks', [
            'source_uuid' => $page->uuid,
            'target_slug' => "links-to-somewhere-else",
        ]);
        $this->assertDatabaseHas('wiki_lite_linkbacks', [
            'source_uuid' => $page->uuid,
            'target_slug' => "to-here-too",
        ]);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::save
     * @covers SavvyWombat\WikiLite\Models\Page::creating
     * @covers SavvyWombat\WikiLite\Models\Page::saving
     * @uses SavvyWombat\WikiLite\Requests\SavePage
     */
    public function it_saves_the_linkback_from_a_new_page()
    {
        $this->post('/wiki/save', [
                'title' => 'This is a new page',
                'content' => 'This [[links to somewhere else]]',
            ])
            ->assertStatus(302)
            ->assertRedirect('/wiki/view/this-is-a-new-page');

        $this->assertDatabaseHas('wiki_lite_linkbacks', [
            'target_slug' => "links-to-somewhere-else",
        ]);
    }

    /*
     * @test
     * @covers SavvyWombat\WikiLite\Models\Page::saving
     */
    public function it_updates_links_when_the_slug_changes()
    {
        $page = factory(Page::class)->create();

        $linkback = factory(LinkBack::class)->make();
        $linkback->target_slug = $page->slug;
        $linkback->save();

        $revision = factory(Page::class)->make();
        $revision->uuid = $page->uuid;
        $revision->save();

        $this->assertDatabaseHas('wiki_lite_linkbacks', [
            'source_uuid' => $linkback->source_uuid,
            'target_slug' => $revision->slug,
        ]);

        $this->assertDatabaseMissing('wiki_lite_linkbacks', [
            'source_uuid' => $linkback->source_uuid,
            'target_slug' => $page->slug,
        ]);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Models\Page::saving
     */
    public function it_only_updates_links_when_it_is_supposed_to()
    {
        $firstPage = factory(Page::class)->create();

        $secondPage = factory(Page::class)->make();
        $secondPage->content = "[[{$firstPage->title}]]";
        $secondPage->save();

        $this->assertDatabaseHas('wiki_lite_linkbacks', [
            'source_uuid' => $secondPage->uuid,
            'target_slug' => $firstPage->slug,
        ]);

        $thirdPage = factory(Page::class)->make();
        $thirdPage->content = "[[{$secondPage->title}]]";
        $thirdPage->save();

        $this->assertDatabaseHas('wiki_lite_linkbacks', [
            'source_uuid' => $secondPage->uuid,
            'target_slug' => $firstPage->slug,
        ]);

        $this->assertDatabaseHas('wiki_lite_linkbacks', [
            'source_uuid' => $thirdPage->uuid,
            'target_slug' => $secondPage->slug,
        ]);
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
            ->assertSee($page->content)
            ->assertSee($page->uuid);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::edit
     */
    public function it_loads_the_latest_revision_for_editing()
    {
        $firstRevision = factory(Page::class)->create();

        $secondRevision = factory(Page::class)->make();
        $secondRevision->uuid = $firstRevision->uuid;
        $secondRevision->save();

        $thirdRevision = factory(Page::class)->make();
        $thirdRevision->uuid = $firstRevision->uuid;
        $thirdRevision->save();        

        $this->get("/wiki/edit/{$firstRevision->slug}")
            ->assertStatus(200)
            ->assertSee("Editing " . $thirdRevision->title)
            ->assertSee($thirdRevision->content)
            ->assertSee($firstRevision->uuid);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::edit
     */
    public function it_loads_an_empty_form_when_creating_new_page()
    {
        $page = factory(Page::class)->create();

        $this->get("/wiki/edit")
            ->assertStatus(200)
            ->assertSee("Creating new page")
            ->assertDontSee($page->uuid);
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\PageController::edit
     */
    public function it_suggests_a_title_when_creating_new_page()
    {
        $this->get("/wiki/edit/this-page-doesnt-exist-yet")
            ->assertStatus(200)
            ->assertSee("Creating new page")
            ->assertSee("This page doesnt exist yet");
    } 
}