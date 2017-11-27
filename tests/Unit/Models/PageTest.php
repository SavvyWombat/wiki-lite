<?php

namespace SavvyWombat\WikiLite\Tests\Unit\Models;

use SavvyWombat\WikiLite\Models\Page;
use SavvyWombat\WikiLite\Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * @test
     * @covers SavvyWombat\WikiLite\Models\Page::setTitleAttribute
     * @uses SavvyWombat\WikiLite\Models\Page::boot
     */
    public function it_sets_the_slug_when_it_gets_a_title()
    {
        $page = new Page();

        $page->title = "Title needs to be slugged";

        $this->assertEquals(
            "title-needs-to-be-slugged",
            $page->slug
        );

        $this->assertEquals(
            "Title needs to be slugged",
            $page->title
        );
    }
}