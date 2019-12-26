<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Group;
use App\Offer;
use App\User;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        "offer_name" => $faker->word,
        "status" => 1,
        "category" => Category::all()->random()->id,
        "url" => $faker->url,
        "image_path" => $faker->image("C:\Users\hp\Desktop\Files"),
        "products_available"=>10,
        'market_price' => "1000",
        "today_price"=>"10",
        "stars"=>4,
        "users_number"=>22,
        "user_id"=>User::all()->random()->id,
        "group_id"=>Group::all()->random()->id,
        "source" => $faker->word,
        "geo" => "IT",
        "currency"=>"$",
        "shippingPrice"=>1,
    ];
});
