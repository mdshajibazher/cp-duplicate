<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;



$factory->define(Product::class, function (Faker $faker) {
    $pd_type = ['ecom','pos'];
    $pd_disc_price = $faker->numberBetween(100,500);
    return [
        'product_name' => $faker->sentence(3),
        'price' => $faker->numberBetween(501,1000),
        'discount_price' => $pd_disc_price,
        'current_price' => $pd_disc_price,
        'category_id' => $faker->numberBetween(1,3),
        'subcategory_id' => $faker->numberBetween(1,6),
        'brand_id' => 1,
        'size_id' => $faker->numberBetween(1,3),
        'description' => $faker->paragraph(4),
        'type' => $pd_type[rand(0,1)],
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
