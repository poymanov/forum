<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_create_activity_when_new_thread_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'user_id' => auth()->id(),
            'type' => 'created_thread',
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($thread->id, $activity->subject->id);
    }

    /** @test */
    public function it_create_activity_when_new_reply_created()
    {
         $this->signIn();

         $reply = create('App\Reply');

         $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function activity_can_return_feed_by_user()
    {
        $user = create('App\User');
        $this->signIn($user);

        create('App\Thread', ['user_id' => $user->id] ,2);

        Activity::first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed($user);

        $this->assertTrue(
            $feed->keys()->contains(Carbon::now()->format('d-m-Y'))
        );

        $this->assertTrue(
            $feed->keys()->contains(Carbon::now()->subWeek()->format('d-m-Y'))
        );
    }
}
