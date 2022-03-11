<?php

use App\Bookdetail;
use Faker\Generator as Faker;

$factory->define(Bookdetail::class, function (Faker $faker) {
    $faker->locale('ja_JP');
    $now = \Carbon\Carbon::now();

    return [
        'isbn' => $faker->isbn13,
        'published_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'price' => $faker->randomNumber(4),
        // コメントアウトしてても、デフォルトで自動的にタイムスタンプは更新される
        // 'created_at' => $now,
        // 'updated_at' => $now,
    ];
});
