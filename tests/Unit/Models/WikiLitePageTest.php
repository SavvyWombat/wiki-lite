<?php

namespace SavvyWombat\WikiLite\Tests\Unit\Models;

use SavvyWombat\WikiLite\Models\WikiLitePage;
use SavvyWombat\WikiLite\Tests\TestCase;

class WikiLitePageTest extends TestCase
{
    public function testSlug()
    {
        $page = new WikiLitePage();

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