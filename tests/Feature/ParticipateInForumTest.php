<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_unauthenticated_user_may_not_add_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be(factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        $this->get('/threads/' . $thread->id)
             ->assertSee($reply->body);
    }
}
