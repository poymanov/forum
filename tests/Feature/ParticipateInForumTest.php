<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function an_unauthenticated_user_may_not_add_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/test/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post("/threads/{$thread->channel->slug}/{$thread->slug}/replies", $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body' => null]);
        $this->post("/threads/{$thread->channel->slug}/{$thread->slug}/replies", $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function an_unauthenticated_user_may_not_delete_reply()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_may_delete_reply()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $thread = $reply->thread;

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $thread->fresh()->replies_count);
    }

    /** @test */
    public function an_unauthenticated_user_may_not_update_reply()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_may_update_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedBody = "New reply body";

        $this->patch("/replies/{$reply->id}", ['body' => $updatedBody]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedBody]);
    }

    /** @test */
    public function it_may_not_create_reply_with_invalid_keywords()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'Yahoo customer support'
        ]);

        $this->json('post', "/threads/{$thread->channel->slug}/{$thread->slug}/replies", $reply->toArray())
        ->assertStatus(422);
    }

    /** @test */
    public function user_may_create_once_reply_per_minute()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post("/threads/{$thread->channel->slug}/{$thread->slug}/replies", $reply->toArray())
        ->assertStatus(201);

        $this->post("/threads/{$thread->channel->slug}/{$thread->slug}/replies", $reply->toArray())
        ->assertStatus(429);
    }

    /** @test */
    public function it_can_search_users_by_name_started_with_query()
    {
        create('App\User', ['name' => 'johndoe']);
        create('App\User', ['name' => 'johnboe']);
        create('App\User', ['name' => 'janevoe']);

        $response = $this->json('get', '/api/users?name=john');

        $this->assertCount(2, $response->json());
    }
}
