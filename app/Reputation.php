<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reputation extends Model
{
    const THREAD_WAS_CREATED = 10;
    const REPLY_POSTED = 2;
    const REPLY_IS_BEST = 50;
    const REPLY_WAS_FAVORITED = 5;

    public static function award($user, $points)
    {
        $user->increment('reputation', $points);
    }

    public static function reduce($user, $points)
    {
        $user->decrement('reputation', $points);
    }
}
