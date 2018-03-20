<?php

namespace Tests\Feature;

use App\Mail\MustConfirmMail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_send_email_to_new_user()
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'Test',
            'email' => 'test@test.ru',
            'password' => '123qwe',
            'password_confirmation' => '123qwe'
        ]);

        Mail::assertSent(MustConfirmMail::class);
    }

    /** @test */
    public function user_can_registered_and_confirmed_account()
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'Test',
            'email' => 'test@test.ru',
            'password' => '123qwe',
            'password_confirmation' => '123qwe'
        ]);

        $user = User::whereName('Test')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $this->get("/register/confirm?token={$user->confirmation_token}")
            ->assertRedirect('/threads');

        tap($user->fresh(), function($user) {
            $this->assertTrue($user->confirmed);
            $this->assertNull($user->confirmation_token);
        });

    }

    /** @test */
    public function it_has_invalid_token()
    {
        $this->get("/register/confirm?token=123")
            ->assertRedirect('/threads')
            ->assertSessionHas('flash');
    }

}
