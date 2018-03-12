<?php

namespace App\Listeners;

use App\Events\ThreadWereReceivedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadWereReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadWereReceivedNewReply $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
