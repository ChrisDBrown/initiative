<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Game;
use App\Services\GameStateService;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Game::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'url_code' => Str::random(10),
        'state' => GameStateService::STATE_ORDER[0],
    ];
});
