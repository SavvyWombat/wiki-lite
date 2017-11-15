<?php

/*
|--------------------------------------------------------------------------
| Wiki Routes
|--------------------------------------------------------------------------
|
*/

Route::group(
    [
        'namespace' => 'SavvyWombat\WikiLite\Controllers',
        'middleware' => ['web'],
    ],
    function() {
        Route::get(config('wiki-lite.base'), 
            [
                'as' => 'wiki-lite.index',
                'uses' => 'WikiController@welcome',
            ]);

        Route::post(config('wiki-lite.base') . "/save",
            [
                'as' => 'wiki-lite.save',
                'uses' => 'WikiController@save',
            ]);
    }
);