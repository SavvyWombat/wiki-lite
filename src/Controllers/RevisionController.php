<?php

namespace SavvyWombat\WikiLite\Controllers;

use Illuminate\Routing\Controller as BaseController;
use SavvyWombat\WikiLite\Models\Page;
use Illuminate\Http\Request;

class RevisionController extends BaseController
{
    public function list($slug)
    {
        try {
            $page = Page::revisions($slug)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $page = new Page();
            $page->title = $slug;

            return response()->view('savvywombat/wiki-lite::page.missing', [
                'page' => $page,
            ], 404);
        }

        return response()->view('savvywombat/wiki-lite::revision.list', [
            'page' => $page,
            'revisions' => Page::revisions($slug)->get(),
        ]);
    }



    public function diff($slug, $from, $to)
    {
        try {
            $page = Page::revisions($slug)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $page = new Page();
            $page->title = $slug;

            return response()->view('savvywombat/wiki-lite::page.missing', [
                'page' => $page,
            ], 404);
        }

        $before = Page::where('revision', $from)->firstOrFail();
        $after = Page::where('revision', $to)->firstOrFail();


        return response()->view('savvywombat/wiki-lite::revision.diff', [
            'page' => $page,
            'before' => $before,
            'after' => $after,
            'diff' => $after->diff($before),
        ]);
    }



    public function diffPost(Request $request)
    {
        return redirect()->route('wiki-lite.diff', [
            'slug' => $request->input('slug'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
        ]);
    }
}