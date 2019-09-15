<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\Player;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(Player::class, function (Faker\Generator $faker) {
	$roles = ['Point Guard', 'Centre', 'Power Forward', 'Small Forward', 'Shooting Guard'];
	return [
		'name' => $faker->name,
		'role' => $faker->randomElement($roles),
		'email' => $faker->email,
	];
});
