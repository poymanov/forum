<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_notify_user_that_be_mentioned()
    {
        $john = create('App\User', [
            'name' => 'JohnDoe'
        ]);

        $jane = create('App\User', [
            'name' => 'JaneDoe'
        ]);

        $this->signIn($john);

        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body' => 'Hey @JaneDoe, check it']);

        $this->post("/threads/{$thread->channel->slug}/{$thread->id}/replies", $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}
