<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BestReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_thread_creator_can_mark_reply_as_best()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $replies = create('App\Reply', ['thread_id' => $thread->id], 2);

        $this->assertFalse($replies[0]->isBest());

        $this->postJson("/replies/{$replies[0]->id}/best");

        $this->assertTrue($replies[0]->fresh()->isBest());
    }

    /** @test */
    public function only_a_thread_creator_can_mark_best_reply()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $replies = create('App\Reply', ['thread_id' => $thread->id], 2);

        $this->signIn();

        $this->postJson("/replies/{$replies[0]->id}/best")->assertStatus(403);

        $this->assertFalse($replies[0]->fresh()->isBest());
    }

    /** @test */
    public function then_reply_deleted_it_reflect_to_thread_best_reply_id()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $reply->thread->markBestReply($reply);

        $this->deleteJson('/replies/' . $reply->id);

        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
}
