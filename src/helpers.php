<?php

if (!function_exists("wikilink")) {
    function wikilink($title) {

        return sprintf("<a href='%s%s'>%s</a>",
            config("wiki-lite.base"),
            str_slug($title),
            $title
        );
    }
}