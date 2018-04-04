<?php

namespace Tests\Feature;

use App\Reputation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_earn_points_when_create_a_thread()
    {
        $thread = create('App\Thread');

        $this->assertEquals(Reputation::THREAD_WAS_CREATED, $thread->creator->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_delete_a_thread()
    {
        $this->signIn();

        $thread = create('App\Thread',
            ['user_id' => auth()->id()]
        );

        $this->assertEquals(Reputation::THREAD_WAS_CREATED, $thread->creator->reputation);

        $this->delete("/threads/{$thread->channel->slug}/{$thread->slug}");

        $this->assertEquals(0, $thread->creator->fresh()->reputation);
    }

    /** @test */
    public function a_user_earn_points_when_add_a_reply()
    {
        $thread = create('App\Thread');

        $reply = $thread->addReply(
            [
                'body' => 'New reply',
                'user_id' => create('App\User')->id
            ]
        );

        $this->assertEquals(Reputation::REPLY_POSTED, $reply->owner->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_delete_a_reply()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = $thread->addReply(
            [
                'body' => 'New reply',
                'user_id' => auth()->id()
            ]
        );

        $this->assertEquals(Reputation::REPLY_POSTED, $reply->owner->reputation);

        $this->delete("/replies/{$reply->id}");

        $this->assertEquals(0, $reply->owner->fresh()->reputation);
    }

    /** @test */
    public function a_user_earn_points_when_they_reply_is_best()
    {
        $thread = create('App\Thread');

        $reply = $thread->addReply(
            [
                'body' => 'New reply',
                'user_id' => create('App\User')->id
            ]
        );

        $thread->markBestReply($reply);

        $total = Reputation::REPLY_POSTED + Reputation::REPLY_IS_BEST;

        $this->assertEquals(52, $reply->owner->reputation);
    }

    /** @test */
    public function a_user_earn_points_when_they_reply_is_favorited()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = $thread->addReply(
            [
                'body' => 'New reply',
                'user_id' => create('App\User')->id
            ]
        );

        $this->post("/replies/{$reply->id}/favorites");

        $total = Reputation::REPLY_POSTED + Reputation::REPLY_WAS_FAVORITED;

        $this->assertEquals($total, $reply->owner->fresh()->reputation);
    }

    /** @test */
    public function a_user_loses_points_when_they_reply_is_unfavorited()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = $thread->addReply(
            [
                'body' => 'New reply',
                'user_id' => create('App\User')->id
            ]
        );

        $this->post("/replies/{$reply->id}/favorites");

        $total = Reputation::REPLY_POSTED + Reputation::REPLY_WAS_FAVORITED;

        $this->assertEquals($total, $reply->owner->fresh()->reputation);

        $this->delete("/replies/{$reply->id}/favorites");

        $total = Reputation::REPLY_POSTED + Reputation::REPLY_WAS_FAVORITED - Reputation::REPLY_WAS_FAVORITED;

        $this->assertEquals($total, $reply->owner->fresh()->reputation);
    }
}
