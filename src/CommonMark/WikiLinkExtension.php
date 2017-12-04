<?php

namespace SavvyWombat\WikiLite\CommonMark;

use League\CommonMark\Extension\Extension;

class WikiLinkExtension extends Extension
{
    /**
     * The wiki link parser
     *
     * @var SavvyWombat\WikiLite\CommonMark\WikiLinkParser
     */
    protected $parser;



    /**
     * @param SavvyWombat\WikiLite\CommonMark\WikiLinkParser $parser
     *
     * @codeCoverageIgnore
     */
    public function __construct(WikiLinkParser $parser)
    {
        $this->parser = $parser;
    }



    /**
     * Returns a list of inline parsers to add to the existing list
     *
     * @return League\CommonMark\Inline\Parser\InlineParserInterface[]
     */
    public function getInlineParsers()
    {
        return [$this->parser];
    }
}