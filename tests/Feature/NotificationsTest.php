<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
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

        $this->signIn();
    }

    /** @test */
    public function an_authenticated_user_can_get_notifications_from_thread_after_new_reply()
    {
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
        create(DatabaseNotification::class);

        $this->assertCount(1,
            $this->json('get', "/profile/" . auth()->user()->name . "/notifications")->json()
        );
    }

    /** @test */
    public function an_authenticated_user_can_mark_as_read_notification()
    {
        create(DatabaseNotification::class);

        tap(auth()->user(), function($user) {

            $this->assertCount(1, $user->unreadNotifications);

            $response = $this->delete("/profile/{$user->name}/notifications/{$user->unreadNotifications->first()->id}");

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}
