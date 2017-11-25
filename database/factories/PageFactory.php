<?php

use SavvyWombat\WikiLite\Models\Page;
use Faker\Generator as Faker;


$factory->define(Page::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'content' => $faker->sentence(),
    ];
});
