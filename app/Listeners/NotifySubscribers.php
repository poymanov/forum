<?php

namespace App\Listeners;

use App\Events\ThreadWereReceivedNewReply;

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
            ->where('user_id', '!=', $event->reply->owner->id)
            ->each->notify($event->reply->thread, $event->reply);
    }
}
