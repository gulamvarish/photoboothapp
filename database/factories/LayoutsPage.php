<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\User;
use App\Models\LayoutsPage;
use Faker\Generator as Faker;

$factory->define(LayoutsPage::class, function (Faker $faker) {
    return [
        'layout_title' => $faker->words(4, true),
        'layout_slug' => $faker->slug,
        'layout_image' => $faker->word,
        'cannonical_link' => $faker->url,        
        'status' => $faker->boolean,
        'created_by' => function () {
            return factory(User::class)->state('active')->create()->id;
        },
    ];
});
