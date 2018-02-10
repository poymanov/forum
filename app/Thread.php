<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reply;

class Thread extends Model
{
    protected $fillable = ['user_id', 'body', 'title'];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
