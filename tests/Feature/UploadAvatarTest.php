<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_members_can_upload_avatars()
    {
        $this->json('post', '/api/users/1/avatar')
        ->assertStatus(401);
    }

    /** @test */
    public function it_can_provide_valid_avatar()
    {
        $this->signIn();

        $this->json('post', '/api/users/' . auth()->id() . '/avatar', [
            'image' => 'not-an-image'
        ])
        ->assertStatus(422);
    }

    /** @test */
    public function an_user_can_upload_avatar()
    {
        Storage::fake('public');

        $this->signIn();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->json('post', '/api/users/' . auth()->id() . '/avatar', [
            'image' => $file
        ]);

        $this->assertEquals(auth()->user()->avatar_path, 'avatars/' . $file->hashName());

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
