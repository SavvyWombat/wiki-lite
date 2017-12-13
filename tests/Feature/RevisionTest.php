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
        $first = factory(Page::class)->create();

        $second = factory(Page::class)->make();
        $second->uuid = $first->uuid;
        $second->save();

        $third = factory(Page::class)->make();
        $third->uuid = $first->uuid;
        $third->save();

        $this->get("/wiki/view/{$first->slug}/revisions")
            ->assertStatus(200)
            ->assertSee("Revision history for: {$third->title}")
            ->assertDontSee($first->content)
            ->assertSee($first->updated_at->toDateTimeString())
            ->assertDontSee($second->content)
            ->assertSee($second->title)
            ->assertSee($second->updated_at->toDateTimeString())
            ->assertDontSee($third->content)
            ->assertSee($third->title)
            ->assertSee($third->updated_at->toDateTimeString());
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

        $this->get("/wiki/view/{$before->slug}/diff/{$after->revision}/{$before->revision}")
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

    /**
     * @test
     * @covers SavvyWombat\WikiLite\Controllers\RevisionController::diffPost
     */
    public function it_redirects_from_post_to_get()
    {
        $this->post("/wiki/diff", [
                'slug' => 'some-slug',
                'from' => 10,
                'to' => 1701,
            ])
            ->assertStatus(302)
            ->assertRedirect('/wiki/view/some-slug/diff/10/1701');
    }
}