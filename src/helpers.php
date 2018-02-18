<?php

use SavvyWombat\WikiLite\Models\Page;

if (!function_exists("wikilink")) {
    function wikilink($title) {
        $slug = str_slug($title);

        $url = str_replace("//", "/", 
            config("wiki-lite.base") . "/view/" . $slug
        );

        $class = 'wiki-lite-wikilink';
        if (!Page::where('slug', $slug)->exists()) {
            $class .= ' wiki-lite-wikilink-missing';
        }

        return "[$title]($url){class='$class'}";
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