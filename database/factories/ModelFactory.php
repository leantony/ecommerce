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

/** @var $factory \Illuminate\Database\Eloquent\Factory  */
$factory->define(App\models\County::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->randomElement(['Nairobi', 'Kisumu', 'Mombasa']),
    ];
});

/** @var $factory \Illuminate\Database\Eloquent\Factory  */
$factory->define(App\models\Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->text(10),
    ];
});

/** @var $factory \Illuminate\Database\Eloquent\Factory  */
$factory->define(App\models\Brand::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->randomElement(['Samsung', 'Acer', 'Asus', 'Nvidia']),
        'logo' => $faker->imageUrl()
    ];
});

/** @var $factory \Illuminate\Database\Eloquent\Factory  */
$factory->define(App\models\SubCategory::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->text(10),
    ];
});

/** @var $factory \Illuminate\Database\Eloquent\Factory  */
$factory->define(App\models\Product::class, function (Faker\Generator $faker) {

    return [
        'sku' => 'PCW' . $faker->randomNumber(6, true),
        'name' => $faker->text(15),
        'price' => $faker->randomNumber(5),
        'discount' => $faker->randomNumber(4),
        'quantity' => $faker->randomNumber(2),
        'description_short' => $faker->paragraph(1),
        'description_long' => $faker->paragraph(),
        'stuff_included' => $faker->paragraph(1),
        'image' => $faker->imageUrl(),
        'image_large' => $faker->imageUrl(1920, 1080)


    ];
});

/** @var $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(\App\Models\Review::class, function(Faker\Generator $faker){
    return [
        'comment' => $faker->paragraph(1),
        'stars' => $faker->numberBetween(1, 5),
    ];
});

/** @var $factory \Illuminate\Database\Eloquent\Factory  */
$factory->define(App\models\User::class, function (Faker\Generator $faker) {
    return [
        'first_name'   => $faker->firstName,
        'last_name'    => $faker->lastName,
        'phone'        => $faker->phoneNumber,
        'town'         => $faker->city,
        'home_address' => $faker->streetAddress,
        'email'        => $faker->email,
        'password'     => app(\Illuminate\Hashing\BcryptHasher::class)->make('123456789' ),
        'confirmed' => 1
    ];
});