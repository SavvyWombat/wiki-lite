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
        Route::get('/', [
            'as' => 'wiki-lite.index',
            'uses' => 'WikiController@welcome',
        ]);

        Route::get('/edit', [
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
    }
);