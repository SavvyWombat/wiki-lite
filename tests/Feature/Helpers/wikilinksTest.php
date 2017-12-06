<?php

namespace SavvyWombat\WikiLite\Tests\Unit\Helpers;

use SavvyWombat\WikiLite\Tests\Feature\TestCase;

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
            sprintf("Content [%s](/wiki/view/%s) content and [%s](/wiki/view/%s)",
                "the title I want to link to",
                "the-title-i-want-to-link-to",
                "another link",
                "another-link"
            ),
            wikilinks("Content [[the title I want to link to]] content and [[another link]]")
        );
    }
}