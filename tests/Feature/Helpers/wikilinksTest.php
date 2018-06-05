<?php

namespace SavvyWombat\WikiLite\Tests\Unit\Helpers;

use SavvyWombat\WikiLite\Tests\Feature\TestCase;

/**
 * @uses SavvyWombat\WikiLite\Models\Page
 */
class wikilinksTest extends TestCase
{
    /**
     * @test
     * @covers \wikilinks
     * @uses \wikilink
     */
    public function it_replaces_all_wikilinks_in_content()
    {
        $this->assertEquals(
            sprintf("Content [%s](/wiki/view/%s){class='wiki-lite-wikilink wiki-lite-wikilink-missing'} content and [%s](/wiki/view/%s){class='wiki-lite-wikilink wiki-lite-wikilink-missing'}",
                "the title I want to link to",
                "the-title-i-want-to-link-to",
                "another link",
                "another-link"
            ),
            wikilinks("Content [[the title I want to link to]] content and [[another link]]")
        );
    }
}