<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_last_reply()
    {
        $user = create('App\User');

        $reply = create('App\Reply', [
            'user_id' => $user->id
        ]);

        $this->assertEquals($user->lastReply->id, $reply->id);
    }
}
