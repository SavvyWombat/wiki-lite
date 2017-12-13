<?php

/*
|--------------------------------------------------------------------------
| Wiki Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    [
        'prefix' => config('wiki-lite.base'),
        'namespace' => 'SavvyWombat\WikiLite\Controllers',
        'middleware' => ['web'],
    ],
    function() {
        // wiki index page
        Route::get('/', [
            'as' => 'wiki-lite.index',
            'uses' => 'WikiController@welcome',
        ]);

        // view and edit pages
        Route::get('/edit/{slug?}', [
            'as' => 'wiki-lite.edit',
            'uses' => 'PageController@edit',
        ]);

        Route::get('/view/{slug}', [
            'as' => 'wiki-lite.view',
            'uses' => 'PageController@view',
        ]);

        Route::post('/save', [
            'as' => 'wiki-lite.save',
            'uses' => 'PageController@save',
        ]);

        // revision history
        Route::get('/view/{slug}/revisions', [
            'as' => 'wiki-lite.revisions',
            'uses' => 'RevisionController@list',
        ]);

        Route::get('/view/{slug}/diff/{from}/{to}', [
            'as' => 'wiki-lite.diff',
            'uses' => 'RevisionController@diff',
        ]);

        Route::post('/diff', [
            'as' => 'wiki-lite.diff-post',
            'uses' => 'RevisionController@diffPost',
        ]);
    }
);