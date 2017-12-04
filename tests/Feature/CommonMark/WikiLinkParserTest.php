<?php

namespace SavvyWombat\WikiLite\Tests\Unit\CommonMark;

use SavvyWombat\WikiLite\CommonMark\WikiLinkParser;
use SavvyWombat\WikiLite\Tests\Feature\TestCase;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Element\Text;
use League\CommonMark\InlineParserContext;
use League\CommonMark\Reference\ReferenceMap;

class WikiLinkParserTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataFor_it_parses_wikilinks
     * @covers SavvyWombat\WikiLite\CommonMark\WikiLinkParser
     *
     * @param string $string
     * @param string $expectedUrl
     * @param string $expectedLabel
     */
    public function it_parses_wikilinks($string, $expectedUrl, $expectedLabel)
    {
        $nodeStub = $this->getMockBuilder(AbstractBlock::class)
            ->getMock();
        $nodeStub->expects($this->any())
            ->method('getStringContent')
            ->willReturn($string);
        $nodeStub->expects($this->once())
            ->method('appendChild')
            ->with($this->callback(function (Link $link) use ($expectedUrl, $expectedLabel) {
                return
                    $link instanceof Link
                    && $expectedUrl === $link->getUrl()
                    && $link->firstChild() instanceof Text
                    && $expectedLabel === $link->firstChild()->getContent();
            }));
        $inlineContext = new InlineParserContext($nodeStub, new ReferenceMap());

        // Move to just before the first brace
        $firstBracePos = mb_strpos($string, '[', null, 'utf-8');
        $inlineContext->getCursor()->advanceBy($firstBracePos);

        $parser = new WikiLinkParser();
        $parser->parse($inlineContext);
    }



    /**
     * @return [ [$string, $expectedUrl, $expectedLabel], ... ]
     */
    public function dataFor_it_parses_wikilinks()
    {
        return [
            ['This is a [[wiki link]]', '/wiki/wiki-link', 'wiki link'],
            ['This is a [[wiki link]] surrounded by text', '/wiki/wiki-link', 'wiki link'],
            ['This is a [[wiki link [using a brace]]]', '/wiki/wiki-link-using-a-brace', 'wiki link [using a brace'],
            ['This is a [[wiki link]] and another closing]]', '/wiki/wiki-link', 'wiki link'],
        ];
    }
}