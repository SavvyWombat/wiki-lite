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
            sprintf("<a href='/wiki/%s'>%s</a>",
                "the-title-i-want-to-link-to",
                "The title I want to link to"
            ),
            wikilink("The title I want to link to")
        );
    }
}