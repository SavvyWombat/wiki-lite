<?php

namespace SavvyWombat\WikiLite\Controllers;

use Illuminate\Routing\Controller as BaseController;
use SavvyWombat\WikiLite\Models\Page;


class WikiController extends BaseController
{
    public function welcome()
    {
        $pages = Page::revisions()
            ->take(20)
            ->get();

        if (count($pages)) {
            return view('wiki-lite::index', 
                [ 'pages' => $pages, ]
            );
        } else {
            return view('wiki-lite::welcome', [
                'page' => new Page(),
            ]);
        }
    }
}