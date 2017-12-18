<?php

use SavvyWombat\WikiLite\Models\LinkBack;
use Faker\Generator as Faker;


$factory->define(LinkBack::class, function (Faker $faker) {
    return [
        'source_uuid' => $faker->uuid(),
        'target_slug' => str_slug($faker->sentence()),
    ];
});
