<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscribe extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notify($thread, $reply)
    {
        $this->user->notify(new ThreadWasUpdated($thread, $reply));
    }
}
