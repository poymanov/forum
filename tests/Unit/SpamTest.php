<?php

namespace Tests\Unit;

use App\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /** @test */
    public function it_validates_text()
    {
        $this->assertFalse(
            (new Spam)->detect('Some text')
        );
    }
}
