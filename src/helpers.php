<?php

if (!function_exists("wikilink")) {
    function wikilink($title) {
        $url = str_replace("//", "/", 
            config("wiki-lite.base") . "/view/" . str_slug($title)
        );

        return "[$title]($url)";
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