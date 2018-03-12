<?php

namespace App\Listeners;

use App\Events\ThreadWereReceivedNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySubscribers
{
    /**
     * Handle the event.
     *
     * @param  ThreadWereReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadWereReceivedNewReply $event)
    {
        $event->reply->thread->subscriptions
            ->where("user_id", "!=", $event->reply->owner->id)
            ->each->notify($event->reply->thread, $event->reply);
    }
}
