<?php

namespace SavvyWombat\WikiLite\Controllers;

use Illuminate\Routing\Controller as BaseController;
use SavvyWombat\WikiLite\Models\Page;
use SavvyWombat\WikiLite\Requests;


class PageController extends BaseController
{
    public function view($slug)
    {
        return view('wiki-lite::view');
    }

    public function edit()
    {
        return view('wiki-lite::edit');
    }

    public function save(Requests\SavePage $request)
    {
        $page = new Page();
        $page->content = $request->input('content');
        $page->title = $request->input('title');
        $page->save();

        return redirect()->route('wiki-lite.view', [
            'slug' => 'fresh-new-wiki-page',
        ]);
    }
}