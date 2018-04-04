<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $fillable = ['body', 'user_id'];

    protected $with = ['owner', 'favorites', 'thread'];

    protected $appends = ['favoritesCount', 'isFavorited', 'isBest'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($reply) {
            $reply->thread->increment('replies_count');
            Reputation::award($reply->owner, Reputation::REPLY_POSTED);
        });

        static::deleted(function($reply) {
            $reply->thread->decrement('replies_count');
            $reply->thread->update(['best_reply_id' => null]);
            Reputation::reduce($reply->owner, Reputation::REPLY_POSTED);
        });
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\w]+)/', $this->body, $matches);

        return $matches[1];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = preg_replace('/@([\w]+)/', '<a href="/profile/$1">$0</a>', $value);
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function getBodyAttribute($value)
    {
        return \Purify::clean($value);
    }
}
