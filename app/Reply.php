<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Reply extends Model
{
    protected $fillable = ['body', 'user_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
