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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
// $factory->define(App\User::class, function (Faker\Generator $faker) {
//     static $password;
//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'password' => $password ?: $password = bcrypt('secret'),
//         'remember_token' => str_random(10),
//     ];
// });
$factory->define(App\Model\CustomerModel::class, function (Faker\Generator $faker) {
    return [
        'realname' => '测试用户'.date('s', time())+rand(1,1000000),
        'username' => $faker->email,
        'mobile' => rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9),
        'password' => bcrypt('test123456'),
        'is_vip' => '2',
        'is_check' => rand(1,3),
        'headimg' => 'img/a5.jpg',
        'sex' => rand(0,2),
    ];
});
