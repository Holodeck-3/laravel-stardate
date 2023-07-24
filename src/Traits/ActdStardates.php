<?php

namespace Holodeck3\Stardate\Traits;

use Illuminate\Support\Carbon;

trait ActdStardates
{
    public function registerActdStardates() : void
    {
        Carbon::macro('actdStardate', function () {
            $year = $this->year - 1900;
            return sprintf("%02d", $year) . $this->format("m.d");
        });
    }
}