<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Character;
use Faker\Generator as Faker;

$factory->define(Character::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'dex_bonus' => random_int(-5, 5),
        'max_hp' => random_int(5, 5000),
        'type' => 'Temp',
    ];
});
