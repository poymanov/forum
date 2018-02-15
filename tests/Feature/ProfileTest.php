<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create('App\User');

        $this->get('/profile/' . $user->name)
            ->assertSee($user->name);
    }

    /** @test */
    public function profile_has_user_threads()
    {
        $user = create('App\User');

        $thread = create('App\Thread', [
            'user_id' => $user->id
        ]);

        $this->get('/profile/' . $user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
