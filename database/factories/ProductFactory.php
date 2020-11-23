<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'      =>  $faker->name,
        'caducidad' =>  $faker->date,
        'user_id'   =>     App\User::all()->random()->id,
    ];
});
