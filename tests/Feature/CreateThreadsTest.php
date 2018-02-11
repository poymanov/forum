<?php

namespace Tests\Feature;

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
    public function an_authenticated_user_can_create_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
        $this->get('/threads/' . $thread->id)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
