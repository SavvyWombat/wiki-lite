<?php

namespace SavvyWombat\WikiLite\Tests\Feature;

use SavvyWombat\WikiLite\Models\Page;

/**
 * @uses SavvyWombat\WikiLite\Models\Page
 * @uses SavvyWombat\WikiLite\ServiceProvider
 * @uses \wikilink
 * @uses \wikilinks
 */
class RevisionTest extends TestCase
{
    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\RevisionController::list
     */
    public function it_lists_the_revisions()
    {
        $page = factory(Page::class)->create();

        $this->get("/wiki/view/{$page->slug}/revisions")
            ->assertStatus(200)
            ->assertSee("Revision history for: ")
            ->assertSee($page->title)
            ->assertDontSee($page->content)
            ->assertSee($page->updated_at->toDateTimeString());
    }

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\RevisionController::diff
     */
    public function it_compares_the_revisions()
    {
        $before = factory(Page::class)->create();

        $after = factory(Page::class)->make();
        $after->uuid = $before->uuid;
        $after->save();

        $latest = factory(Page::class)->make();
        $latest->uuid = $before->uuid;
        $latest->save();

        $this->get("/wiki/view/{$before->slug}/diff/{$before->revision}/{$after->revision}")
            ->assertStatus(200)
            ->assertSee("Comparing {$latest->title}")
            ->assertSee($before->title)
            ->assertSee($after->title)
            ->assertSee($before->updated_at->toDateTimeString())
            ->assertSee($after->updated_at->toDateTimeString())
            ->assertSee("--- Original")
            ->assertSee("+++ New")
            ->assertSee("-{$before->content}")
            ->assertSee("+{$after->content}");
    }
}