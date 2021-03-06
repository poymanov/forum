<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_reply_have_a_owner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test */
    public function it_knows_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_return_mention_users()
    {
        $reply = create('App\Reply', [
            'body' => '@JaneDoe wants to talk with @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wrap_mentioned_users()
    {
        $reply = create('App\Reply', [
            'body' => 'Hello, @JaneDoe'
        ]);

        $this->assertEquals(
            'Hello, <a href="/profile/JaneDoe">@JaneDoe</a>',
            $reply->body
        );
    }

    /** @test */
    public function it_known_that_it_is_best_reply()
    {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

   /** @test */
   public function a_reply_body_automatically_sanitazed()
   {
        $thread = make('App\Reply', ['body' => "<script>alert('test')</script><p>ok</p>"]);

        $this->assertEquals("<p>ok</p>", $thread->body);
   }
}
