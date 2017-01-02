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
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'username' => $faker->userName . $faker->randomNumber(4),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'birthday' => $faker->date('Y-m-d', '-15 years'),
        'verified_at' => function () use ($faker) {
            return $faker->boolean(20) ? $faker->dateTimeBetween('-6 months', 'now') : null;
        },
        'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
    ];
});

$factory->define(\App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->paragraph(rand(1, 10)),
        'user_id' => function () use ($faker) {
            $rand = $faker->numberBetween(0, 100);
            $user = null;

            if ($rand < 90) {
                $user = \App\Models\User::orderByRaw('RANDOM()')->first();
            }

            return $user->id ?? factory(\App\Models\User::class)->create()->id;
        },
        'target_id' => function () use ($faker) {
            $rand = $faker->numberBetween(0, 100);

            if ($rand > 90) {
                return factory(\App\Models\User::class)->create()->id;
            }

            if ($rand > 65) {
                return \App\Models\User::orderByRaw('RANDOM()')->first()->id ?? null;
            }

            return null;
        },
        'type' => \App\Models\Maps\PostsTableMap::TYPE_TEXT,
        'privacy_type' => \App\Models\Maps\PostsTableMap::PRIVACY_PUBLIC,
    ];
});
