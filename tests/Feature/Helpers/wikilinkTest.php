<?php

namespace SavvyWombat\WikiLite\Tests\Unit\Helpers;

use SavvyWombat\WikiLite\Tests\Feature\TestCase;

class wikilinkTest extends TestCase
{
    /**
     * @test
     * @covers \wikilink
     */
    public function it_generates_a_link_based_on_title()
    {
        $this->assertEquals(
            sprintf("[%s](/wiki/view/%s)",
                "The title I want to link to",
                "the-title-i-want-to-link-to"
            ),
            wikilink("The title I want to link to")
        );
    }
}