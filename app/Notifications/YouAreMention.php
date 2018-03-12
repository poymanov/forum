<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class YouAreMention extends Notification
{
    use Queueable;

    protected $reply;

    /**
     * YouAreMention constructor.
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->reply->owner->name . ' mentioned you on ' . $this->reply->thread->title,
            'link' => route('threads.show', [
                'channel' => $this->reply->thread->channel->slug, 'thread' => $this->reply->thread->id
            ]) . "#reply-{$this->reply->id}"
        ];
    }
}
