<?php

if (!function_exists("wikilink")) {
    function wikilink($title) {

        return sprintf("[%s](%s/view/%s)",
            $title,
            config("wiki-lite.base"),
            str_slug($title)
        );
    }
}

if (!function_exists("wikilinks")) {
    function wikilinks($content) {
        $matches = [];
        preg_match_all("#\[\[(.*)\]\]#U",
            $content,
            $matches,
            PREG_SET_ORDER
        );        

        foreach ($matches as $link) {
            $content = str_replace($link[0], 
                wikilink($link[1]),
                $content
            );
        }
        

        return $content;
    }
}