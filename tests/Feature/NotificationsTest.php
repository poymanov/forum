<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function an_authenticated_user_can_get_notifications_from_thread_after_new_reply()
    {
        $this->signIn();

        $user = auth()->user();

        $thread = create('App\Thread');

        $thread->subscribe();

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'New reply text'
        ]);

        $this->assertCount(0, $user->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'New reply text'
        ]);

        $this->assertCount(1, $user->fresh()->notifications);
    }

    /** @test */
    public function an_authenticated_user_can_get_unread_notifications()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'New reply text'
        ]);

        $user = auth()->user()->name;

        $response = $this->json('get', "/profile/{$user}/notifications")->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function an_authenticated_user_can_mark_as_read_notification()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'New reply text'
        ]);

        $user = auth()->user();

        $notification = $user->notifications()->first();

        $response = $this->delete("/profile/{$user->name}/notifications/{$notification->id}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);

    }
}
