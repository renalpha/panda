<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Domain\Entities\PandaGroup\PandaGroup::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name' => $name,
        'label' => str_slug($name),
        'uuid' => \Illuminate\Support\Str::uuid(),
    ];
});
