<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Producto;
use Faker\Generator as Faker;

$factory->define(Producto::class, function (Faker $faker) {
    return [
        'nombre'             => $faker->sentence,
        'precio'     => $faker->randomFloat($nbMaxDecimals = 6, $min = 0, $max = 20),
    ];
});
