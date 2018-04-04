<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ThreadWereReceivedNewReply
{
    use Dispatchable, SerializesModels;

    public $reply;

    /**
     * ThreadWereReceivedNewReply constructor.
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }
}
