<?php

namespace SavvyWombat\WikiLite\Controllers;

use Illuminate\Routing\Controller as BaseController;


class WikiController extends BaseController
{
    public function welcome()
    {
        return view('wiki-lite::welcome');
    }



    public function save()
    {
        return "TODO: save the content";
    }
}