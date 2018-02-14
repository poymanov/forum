<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reply;
use App\Channel;
use App\Filters\ThreadFilters;

class Thread extends Model
{
    protected $fillable = ['user_id', 'body', 'title', 'channel_id'];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * Apply all relevant thread filters.
     * @param $query
     * @param ThreadFilters $filters
     * @return mixed
     */
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
