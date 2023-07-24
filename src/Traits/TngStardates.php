<?php

namespace Holodeck3\Stardate\Traits;

use Holodeck3\Stardate\StardateServiceProvider;
use Illuminate\Support\Carbon;

trait TngStardates {
    public const zeroDate = '2318-07-05 12:00:00'; // July 5, 2318 at roughly noon Starfleet Command Time is Stardate 00000.0
    public const starfleetCommandZone = 'America/Los_Angeles'; // Starfleet Command is in San Francisco
    public const millisecondsPerStarDate = 34367056.4; // 1 Stardate = 34367056.4 milliseconds

    public function registerTngStardates() : void
    {
        Carbon::macro('tngStardate', function (int $precision = 1) : string {
            // Calculation from http://trekguide.com/Stardates.htm
            $zeroDate = Carbon::parse(StardateServiceProvider::zeroDate, StardateServiceProvider::starfleetCommandZone);

            $diffInMiliseconds = $zeroDate->diffInMilliseconds($this, false);
            $stardate = round($diffInMiliseconds / StardateServiceProvider::millisecondsPerStarDate, $precision, PHP_ROUND_HALF_UP);

            return sprintf("%07.{$precision}f", $stardate);
        });

        Carbon::macro('createFromStardate', function (float|string $stardate) : Carbon {
            // Calculation from http://trekguide.com/Stardates.htm
            $zeroDate = Carbon::parse(StardateServiceProvider::zeroDate, StardateServiceProvider::starfleetCommandZone);

            $diffInMiliseconds = $stardate * StardateServiceProvider::millisecondsPerStarDate;
            $date = $zeroDate->addMilliseconds($diffInMiliseconds);

            return $date;
        });

        Carbon::macro('contemporaryStardate', function (int $precision = 1) {
            $futureYear = $this->copy()->addYears(331);
            return $futureYear->tngStardate($precision);
        });

    }
}