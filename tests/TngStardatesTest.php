<?php

namespace Holodeck3\Stardate\Tests;

use Illuminate\Support\Carbon;

class TngStardatesTest extends TestCase
{

    /**
     * @dataProvider provideTestRealdates
     */
    public function testStardateFormatter($date, $stardate)
    {
        $this->assertEquals($stardate, Carbon::parse($date)->tngStardate());
    }

    public static function provideTestRealdates() : array
    {
        return [
            'Stardate 0' => ['2318-07-05 18:41:10.0', '00000.0'],
            'VOY: Homestead' => ['2378-04-06 16:52:10.789', '54868.6'],
        ];
    }

    /**
     * @dataProvider provideTestStardates
     */
    public function testCreateFromStardate(string|float $stardate, string $date)
    {
        $this->assertEquals($date, Carbon::createFromStardate($stardate)->format("Y-m-d"));
    }
    
    public static function provideTestStardates() : array
    {
        return [
            'Stardate 0' => [0.0, '2318-07-05'],
            'TNG: Encounter at Farpoint' => [41153.7, '2363-04-30'],
            'TNG: The Neutral Zone' => [41986.0, '2364-03-26'],
            "TNG: Data's Day" => [44390.1, '2366-11-07'],
            "TNG: All Good Things..." => [47988.0, '2370-10-08'],
            'VOY: Caretaker' => [48315.6, '2371-02-15'],
            'VOY: Eye of the Needle' => [48579.4, '2371-05-31'],
            "VOY: The 37's" => [48975.1, '2371-11-05'],
            'VOY: Homestead' => [54868.6, '2378-04-06'],
        ];
    }

    public function testTngSeriesSpread()
    {
        $farpoint = Carbon::createFromStardate(41153.7);
        $allGoodThings = Carbon::createFromStardate(47988.0);
        $this->assertEquals(7, $farpoint->diffInYears($allGoodThings));
    }

    /**
     * @dataProvider provideTestContemporaryDates
     */
    public function testContemporaryDates(string $date, float|string $stardate)
    {
        $this->assertEquals($stardate, Carbon::parse($date)->contemporaryStardate());
    }

    public function provideTestContemporaryDates() : array
    {
        return [
            'Stardate 41000.0' => ['1987-07-15 07:00:00', '41000.0'],
            'Stardate 74077.2' => ['2023-07-23 07:00:00', '74077.2'],
            'Stardate 47295.5' => ['1994-05-23 10:00:00', '47295.5']
        ];
    }

    /**
     * @dataProvider provideTestContemporaryDates
     */
    public function testCreateFromContemporaryStardate(string $date, float|string $stardate)
    {
        $expectedDate = Carbon::parse($date);
        $this->assertEquals($expectedDate->format("Y-m-d"), Carbon::createFromContemporaryStardate($stardate)->format("Y-m-d"));
    }
}
