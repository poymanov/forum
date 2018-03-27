<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_threads()
    {
        config(['scout.driver' => 'algolia']);

        $query = 'foobar';

        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "Body with search content: {$query}"], 2);

        do {
            sleep(.25);
            $result = $this->getJson("/threads/search?q={$query}")->json()['data'];
        } while(empty($result));


        $this->assertCount(2, $result);
    }
}
