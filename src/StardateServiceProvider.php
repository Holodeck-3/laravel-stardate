<?php

namespace Holodeck3\Stardate;

use Holodeck3\Stardate\Traits\TngStardates;
use Holodeck3\Stardate\Traits\ActdStardates;
use Holodeck3\Stardate\Traits\Holidays;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class StardateServiceProvider extends ServiceProvider
{
    use TngStardates;
    use ActdStardates;
    use Holidays;


    public function boot()
    {
    }

    public function register()
    {
        $this->registerActdStardates();
        $this->registerTngStardates();
        $this->registerHolidays();
    }
}
