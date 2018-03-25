<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_administrator_can_not_lock_the_thread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post("/lock-thread/{$thread->slug}")
        ->assertStatus(403);

        $this->assertFalse($thread->fresh()->locked);
    }

    /** @test */
    public function administrator_can_lock_the_thread()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread');

        $this->post("/lock-thread/{$thread->slug}");

        $this->assertTrue($thread->fresh()->locked);
    }

    /** @test */
    public function administrator_can_unlock_the_thread()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['locked' => true]);

        $this->delete("/lock-thread/{$thread->slug}");

        $this->assertFalse($thread->fresh()->locked);
    }

    /** @test */
    public function once_locked_thread_can_not_be_replied()
    {
        $this->signIn();

        $thread = create('App\Thread', ['locked' => true]);

        $this->post('/threads/' . $thread->channel->slug . '/' . $thread->slug . '/replies', [
            'body' => 'New reply',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}
