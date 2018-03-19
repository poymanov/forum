<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
             ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_single_thread()
    {
        $this->get("/threads/{$this->thread->channel->name}/{$this->thread->id}")
             ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_threads_associated_with_channel()
    {
        $channel = create('App\Channel');

        $threadSeeInChannel = create('App\Thread', [
            'channel_id' => $channel->id
        ]);

        $threadNotSeeInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadSeeInChannel->title)
            ->assertDontSee($threadNotSeeInChannel->title);

    }

    /** @test */
    public function a_user_can_filter_threads_by_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->json('get', '/threads?popular=1')->json();
        
        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_by_unanswered_count()
    {
        create('App\Reply');

        $response = $this->json('get', '/threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test */
    public function it_can_request_replies_by_thread()
    {
        $thread = $this->thread;
        create('App\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->json('get', "/threads/{$thread->channel->name}/{$thread->id}/replies")->json();

        $this->assertCount(2, $response['data']);
    }

    /** @test */
    public function it_increments_visits_each_time_thread_visit()
    {
        $thread = create('App\Thread');

        $this->assertEquals(0, $thread->fresh()->visits);

        $this->get("/threads/{$thread->channel->name}/{$thread->id}");

        $this->assertEquals(1, $thread->fresh()->visits);
    }
}
