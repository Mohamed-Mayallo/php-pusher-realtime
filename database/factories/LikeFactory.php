<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Like;
use App\User;
use App\Reply;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'reply_id' => Reply::all()->random(),
        'user_id' => User::all()->random()
    ];
});
