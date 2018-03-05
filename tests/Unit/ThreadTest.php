<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
   use RefreshDatabase;

   public function setUp()
   {
       parent::setUp();

       $this->thread = create('App\Thread');
   }

    /** @test */
   public function a_thread_has_replies()
   {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
   }

   /** @test */
   public function a_thread_has_a_creator()
   {
       $this->assertInstanceOf('App\User', $this->thread->creator);
   }

   /** @test */
   public function a_thread_can_add_a_reply()
   {
       $this->thread->addReply([
           'body' => 'Foobar',
           'user_id' => 1
       ]);

       $this->assertCount(1, $this->thread->replies);
   }

   /** @test */
   public function a_user_get_notification_for_new_reply()
   {
        Notification::fake();

        $this->signIn();

        $this->thread->subscribe();

        $this->thread->addReply([
           'body' => 'Foobar',
           'user_id' => create('App\User')->id
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
   }

   /** @test */
   public function a_thread_has_a_channel()
   {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
   }

   /** @test */
   public function a_thread_can_subscribe_to()
   {
       $thread = create('App\Thread');

       $userId = 1;

       $thread->subscribe($userId);

       $this->assertEquals(1,
           $thread->subscriptions()->where('user_id', $userId)->get()->count());
   }

   /** @test */
   public function a_thread_can_unsubscribe_from()
   {
       $thread = create('App\Thread');

       $userId = 1;

       $thread->subscribe($userId);
       $thread->unsubscribe($userId);

       $this->assertCount(0, $thread->subscriptions);
   }

   /** @test */
   public function a_thread_can_check_subscribe_to()
   {
       $thread = create('App\Thread');

       $this->signIn();

       $this->assertFalse($thread->isSubscribedTo);

       $thread->subscribe();

       $this->assertTrue($thread->isSubscribedTo);
   }
}
