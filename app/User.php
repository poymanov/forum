<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;

    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'confirmation_token'
    ];

    protected $casts = [
        'confirmed' => 'boolean'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function activities()
    {
        return $this->hasMany('App\Activity');
    }

    public function readThread($thread)
    {
        $key = $this->cacheKeyThreadVisit($thread);
        Cache::forever($key, Carbon::now());
    }

    public function cacheKeyThreadVisit($thread)
    {
        return sprintf('users.%s.visits.%s', $this->id, $thread->id);
    }

    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? '/storage/' . $avatar : 'images/default.png');
    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }
}
