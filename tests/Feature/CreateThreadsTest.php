<?php

namespace Tests\Feature;

use App\Activity;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function an_unauthenticated_user_may_not_add_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads', []);
    }

    /** @test */
    public function an_unauthenticated_may_not_see_create_form()
    {
        $this->withExceptionHandling()
            ->get('threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_must_confirm_email_before_create_thread()
    {
        $user = factory('App\User')->states('unconfirmed')->create();

        $this->signIn($user);

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray())
            ->assertRedirect('/threads')
            ->assertSessionHas('flash');
    }

    /** @test */
    public function an_authenticated_user_can_create_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', [
            'title' => 'Test Title',
            'slug' => 'test-title',
        ]);

        $this->assertEquals($thread->fresh()->slug, 'test-title');

        $this->post('/threads', $thread->toArray());

        $this->assertTrue(Thread::whereSlug('test-title-2')->exists());

        $this->post('/threads', $thread->toArray());

        $this->assertTrue(Thread::whereSlug('test-title-3')->exists());
    }

    /** @test */
    public function a_thread_requires_valid_channel()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 9999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorize_cannot_delete_thread()
    {
        $thread = create('App\Thread');

        $this->withExceptionHandling();
        $this->delete('/threads/' . $thread->channel->slug . '/' . $thread->slug)
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete('/threads/' . $thread->channel->slug . '/' . $thread->slug)
            ->assertStatus(403);

    }

    /** @test */
    public function authorize_user_can_delete_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $this->delete('/threads/' . $thread->channel->slug . '/' . $thread->slug);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id])
            ->assertDatabaseMissing('replies', ['id' => $reply->id])
            ->assertEquals(0, Activity::count());
    }

    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }
}
