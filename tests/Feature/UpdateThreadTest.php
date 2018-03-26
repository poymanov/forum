<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->signIn()->withExceptionHandling();
    }

    /** @test */
    public function a_thread_require_title_and_body_to_be_updated()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch("/threads/{$thread->channel->slug}/{$thread->slug}", [
            'title' => 'Some title'
        ])->assertSessionHasErrors('body');

        $this->patch("/threads/{$thread->channel->slug}/{$thread->slug}", [
            'body' => 'Some body'
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function only_creator_may_update_a_thread()
    {
        $thread = create('App\Thread', ['user_id' => create('App\User')]);

        $this->patch("/threads/{$thread->channel->slug}/{$thread->slug}", [])
            ->assertStatus(403);
    }

    /** @test */
    public function user_can_update_a_thread()
    {
        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch("/threads/{$thread->channel->slug}/{$thread->slug}", [
            'title' => 'Some title',
            'body' => 'Some body'
        ]);

        tap($thread->fresh(), function($thread) {
            $this->assertEquals('Some title', $thread->title);
            $this->assertEquals('Some body', $thread->body);
        });
    }
}
