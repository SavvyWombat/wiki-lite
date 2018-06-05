<?php

namespace SavvyWombat\WikiLite\Tests\Unit\Helpers;

use SavvyWombat\WikiLite\Tests\Feature\TestCase;
use SavvyWombat\WikiLite\Models\Page;

/**
 * @uses SavvyWombat\WikiLite\Models\Page
 */
class wikilinkTest extends TestCase
{
    /**
     * @test
     * @covers \wikilink
     */
    public function it_generates_a_missing_link_based_on_title()
    {
        $this->assertEquals(
            sprintf("[%s](/wiki/view/%s){class='wiki-lite-wikilink wiki-lite-wikilink-missing'}",
                "The title I want to link to",
                "the-title-i-want-to-link-to"
            ),
            wikilink("The title I want to link to")
        );
    }

    /**
     * @test
     * @covers \wikilink
     */
    public function it_generates_a_link_based_on_title()
    {
        $page = factory(Page::class)->create();
        $page->title = "The title I want to link to";
        $page->save();

        $this->assertEquals(
            sprintf("[%s](/wiki/view/%s){class='wiki-lite-wikilink'}",
                "The title I want to link to",
                "the-title-i-want-to-link-to"
            ),
            wikilink("The title I want to link to")
        );
    }
}