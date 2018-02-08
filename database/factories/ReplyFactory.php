<?php

use Faker\Generator as Faker;
use App\Thread;
use App\User;
use App\Reply;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'thread_id' => factory(Thread::class)->create()->id,
        'user_id' => factory(User::class)->create()->id,
        'body' => $faker->paragraph
    ];
});
