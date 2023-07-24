<?php

namespace Holodeck3\Stardate\Tests;

use Illuminate\Support\Carbon;

class HolidaysTest extends TestCase
{
    public function testFirstContactDay()
    {
        $this->assertTrue(Carbon::parse('2063-04-05')->isFirstContactDay());
        $this->assertFalse(Carbon::parse('2063-04-06')->isFirstContactDay());
        $this->assertTrue(Carbon::parse('2063-04-06')->nextFirstContactDay()->isFirstContactDay());
        $this->assertTrue(Carbon::parse('2063-04-04')->lastFirstContactDay()->isFirstContactDay());
        $this->assertEquals('4 days', Carbon::parse('2063-04-01')->untilFirstContactDay()->forHumans());
    }
}