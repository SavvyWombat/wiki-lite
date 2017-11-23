<?php

namespace SavvyWombat\WikiLite\Controllers;

use Illuminate\Routing\Controller as BaseController;
use SavvyWombat\WikiLite\Requests;


class PageController extends BaseController
{
    public function edit()
    {
        return view('wiki-lite::edit');
    }

    public function save(Requests\SavePage $request)
    {
        return "TODO: save the content";
    }
}