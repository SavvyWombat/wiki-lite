<?php

namespace SavvyWombat\WikiLite\Tests\Unit\Models;

use SavvyWombat\WikiLite\Models\Page;
use SavvyWombat\WikiLite\Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * @covers SavvyWombat\WikiLite\Models\Page::setTitleAttribute
     * @uses SavvyWombat\WikiLite\Models\Page::boot
     */
    public function testSlugIsSetWithTitle()
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