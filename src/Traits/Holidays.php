<?php

namespace Holodeck3\Stardate\Traits;

use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait Holidays
{
    public function registerHolidays()
    {
        $holidays = [
            "First Contact Day" => ['month' => 4, 'day' => 5, 'label' => 'First Contact Day'],
            "Star Trek Day" => ['month' => 9, 'day' => 8, 'label' => 'Star Trek Day'],
            "Captain Picard Day" => ['month' => 6, 'day' => 16, 'label' => 'Captain Picard Day'],
            "Frontier Day" => ['month' => 4, 'day' => 14, 'label' => 'Frontier Day'],
            "Ancestor's Eve" => ['month' => 4, 'day' => 22, 'label' => "Ancestor's Eve"],
        ];

        foreach ($holidays as $label => $holiday) {
            Carbon::macro(Str::camel("is {$label}"), function () use ($holiday) : bool {
                return $this->month === $holiday['month'] && $this->day === $holiday['day'];
            });
            Carbon::macro(Str::camel("next {$label}"), function () use ($holiday) : Carbon {
                $nextHoliday = $this->copy()->setDate($this->year, $holiday['month'], $holiday['day']);
                if ($nextHoliday->isPast()) {
                    $nextHoliday->addYear();
                }
                return $nextHoliday;
            });
            Carbon::macro(Str::camel("last {$label}"), function () use ($holiday) : Carbon {
                $lastHoliday = $this->copy()->setDate($this->year, $holiday['month'], $holiday['day']);
                if ($lastHoliday->isFuture()) {
                    $lastHoliday->subYear();
                }
                return $lastHoliday;
            });
            Carbon::macro(Str::camel("until {$label}"), function () use ($label, $holiday) : CarbonInterval {
                $nextHolidaySlug = Str::camel("next {$label}");
                $nextHoliday = $this->$nextHolidaySlug();

                return $this->diffAsCarbonInterval($nextHoliday);
            });

            Carbon::macro(Str::camel("since {$label}"), function () use ($label, $holiday) : CarbonInterval {
                $lastHolidaySlug = Str::camel("last {$label}");
                $lastHoliday = $this->$lastHolidaySlug();

                return $this->diffAsCarbonInterval($lastHoliday);
            });
        }

        Carbon::macro('trekHoliday', function () use ($holidays) : ?string {
            foreach ($holidays as $label => $holiday) {
                if ($this->month === $holiday['month'] && $this->day === $holiday['day']) {
                    return $label;
                }
            }
            return null;
        });

        Carbon::macro('isTrekHoliday', function () use ($holidays) : bool {
            return $this->trekHoliday() !== null;
        });
    }
}