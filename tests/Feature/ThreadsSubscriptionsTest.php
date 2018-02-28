<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsSubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function an_authenticated_user_can_subscribe_to_thread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post("/threads/{$thread->channel->name}/{$thread->id}/subscriptions");

        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function an_authenticated_user_can_unsubscribe_from_thread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->delete("/threads/{$thread->channel->name}/{$thread->id}/subscriptions");

        $this->assertCount(0, $thread->subscriptions);
    }
}
