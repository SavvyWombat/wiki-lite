<?php

namespace SavvyWombat\WikiLite\CommonMark;

use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\InlineParserContext;
use League\CommonMark\Util\UrlEncoder;

class WikiLinkParser extends AbstractInlineParser
{
    const WIKILINK_REGEX = '#^\[\[(.*(?=(\]\])))\]\]#U';

    /**
     * @return string[]
     */
    public function getCharacters()
    {
        return ['['];
    }

    /**
     * @param League\CommonMark\InlineParserContext $inlineContext
     *
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();
        if ($m = $cursor->match(self::WIKILINK_REGEX)) {
            $dest = substr($m, 2, -2);
            $slug = str_slug($dest);
            $url = config('wiki-lite.base') . $slug;

            $inlineContext->getContainer()
                ->appendChild(new Link(UrlEncoder::unescapeAndEncode($url), $dest));

                return true;
        }

        return false;
    }
}