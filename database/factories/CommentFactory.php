<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\User;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment'   =>     $faker->text($maxNbChars =150 ),
        'user_id'   =>     App\User::all()->random()->id,
        'product_id'=>     App\Product::all()->random()->id,
    ];
});
