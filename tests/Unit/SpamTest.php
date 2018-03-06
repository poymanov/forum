<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->spam = new Spam;
    }

    /** @test */
    public function it_validates_text()
    {
        $this->assertFalse($this->spam->detect('Some text'));

        $this->expectException(\Exception::class);

        $this->assertTrue($this->spam->detect('yahoo customer support'));
    }

    /** @test */
    public function it_validated_key_held_down()
    {
        $this->expectException(\Exception::class);

        $this->assertTrue($this->spam->detect('aaaaaaaaaaaaaaaaaaaaaa'));
    }
}
