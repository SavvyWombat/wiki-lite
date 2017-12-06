<?php

namespace SavvyWombat\WikiLite\Controllers;

use Illuminate\Routing\Controller as BaseController;
use SavvyWombat\WikiLite\Models\Page;
use SavvyWombat\WikiLite\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PageController extends BaseController
{
    public function view($slug)
    {
        try {
            $page = Page::revisions($slug)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $page = new Page();
            $page->title = $slug;

            return response()->view('wiki-lite::missing', [
                'page' => $page,
            ], 404);
        }

        return view('wiki-lite::view', [
            'page' => $page,
        ]);
    }

    public function edit($slug = '')
    {
        try {
            $page = Page::revisions($slug)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $page = new Page();
            $page->title = $slug;
        }

        return view('wiki-lite::edit', [
            'page' => $page,
        ]);
    }

    public function save(Requests\SavePage $request)
    {
        $page = new Page();
        if ($request->input('uuid')) {
            $page->uuid = $request->input('uuid');
        }
        $page->content = $request->input('content');
        $page->title = $request->input('title');
        $page->save();

        return redirect()->route('wiki-lite.view', [
            'slug' => $page->slug,
        ]);
    }
}