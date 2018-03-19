<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $thread;

    /**
     * Visits constructor.
     * @param $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }

    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    public function count()
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }
}