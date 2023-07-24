<?php

namespace Holodeck3\Stardate\Tests;

use Illuminate\Support\Carbon;

class HolidaysTest extends TestCase
{
    public function testFirstContactDay()
    {
        $april1 = Carbon::parse('2063-04-01');
        $april4 = Carbon::parse('2063-04-04');
        $april5 = Carbon::parse('2063-04-05');
        $april6 = Carbon::parse('2063-04-06');

        $this->assertTrue($april5->isFirstContactDay());
        $this->assertEquals("First Contact Day", $april5->trekHoliday());

        $this->assertFalse($april6->isFirstContactDay());
        $this->assertTrue($april6->nextFirstContactDay()->isFirstContactDay());
        $this->assertTrue($april4->lastFirstContactDay()->isFirstContactDay());
        $this->assertEquals('4 days', $april1->untilFirstContactDay()->forHumans());
    }
}
