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
                'uses' => 'WikiController@welcome'
            ]);
    }
);