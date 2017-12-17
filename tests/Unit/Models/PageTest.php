<?php

namespace SavvyWombat\WikiLite\Tests\Unit\Models;

use SavvyWombat\WikiLite\Models\Page;
use SavvyWombat\WikiLite\Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * @test
     * @covers SavvyWombat\WikiLite\Models\Page::setTitleAttribute
     * @uses SavvyWombat\WikiLite\Models\Page
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



    /**
     * @test
     * @covers SavvyWombat\WikiLite\Models\Page::setUuidAttribute
     * @uses SavvyWombat\WikiLite\Models\Page
     */
    public function it_does_not_allow_uuid_to_be_modified()
    {
        $page = new Page();

        $page->uuid = "123456";
        $page->uuid = "789123";

        $this->assertEquals(
            "123456",
            $page->uuid
        );
    }



    /**
     * @test
     * @covers SavvyWombat\WikiLite\Models\Page::links
     * @uses SavvyWombat\WikiLite\Models\Page
     */
    public function it_can_extract_wiki_links()
    {
        $page = new Page();

        $page->content = "This is the content, and this is [[a link]], and this is [[another link]]";

        $this->assertEquals(
            [
                "a-link" => "a link",
                "another-link" => "another link",
            ],
            $page->links()
        );
    }
}