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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'mobile' => $faker->phoneNumber,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\MerchantStore::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->unique()->numberBetween($min = 1, $max = 10),
        'store_name' => $faker->company,
        'logoUrl' => 'default.jpg',
        'description' => $faker->sentence($nbWords = 10),
        'cost_two' => '500',
        'landline' => $faker->phoneNumber, 
    ];
});

$factory->define(App\MerchantStoreAddress::class, function (Faker\Generator $faker) {
    return [
        'street' => $faker->streetAddress,
        'city_id' => '1',
        'area_id' => '1',
        'state_id' => '1',
        'country_id' => '1',
        'pincode' =>'500072',
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
    ];
});

$factory->define(App\Offers::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence($nbWords = 6),
        'fineprint' => $faker->paragraph($nbSentences = 3),
        'startDate' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = '+5 days'),
        'endDate' => $faker->dateTimeBetween($startDate = '+6 days', $endDate = '+10 days'),
    ];
});