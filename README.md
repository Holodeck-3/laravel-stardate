# laravel-stardate
Carbon macros for Laravel Star Trek Date based calculations.

## Stardate Calculators
- `Carbon::actdStardate()` converts carbon dates into pseudo-stardates as used in the ST:ACTD Role playing game and defined in [their player's handbook](http://startrek.acalltoduty.com/wiki/index.php/All_Division_Player_Handbook#Stardate_Format)
- `Carbon::tngStardate(int $precision = 1) : string` formats Carbon dates into TNG stardates using the formula[reverse engineered by trekguide.com](http://trekguide.com/Stardates.htm#TNG).  You can pass an integer in the parenthesis to adjust the decimal precision (default is 1 digit)
- `Carbon::createFromStardate(float|string $stardate) : Carbon` creates a carbon instance from a given stardate (allowing you to convert it back into corresponding earth dates)
- `Carbon::contemporaryStardate(int $precision = 1) : string` formats Carbon dates into TNG stardates using the same formula as `Carbon::tngStardate()` but first adds 331 years.  This way dates in 1987 appear as if they were in the year 2363 (allowing dates contemporary with TNG era series airing to roughly coincide with the corresponding stardates in the show).  Somewhat necessary for dates before 2318 which would calculate to negative stargates.

## Star Trek Holidays
Inspired by [dansoppelsa/laravel-carbon-macros](https://packagist.org/packages/dansoppelsa/laravel-carbon-macros) several functions have been added for Star Trek specific holidays.

- **is*HolidayName*()** function returning true if it is a given holiday or not
- **next*HolidayName*()** function returning a `Carbon` date of the next instance of the given holiday after the current date object
- **last*HolidayName*()** function returning a `Carbon` date of the previous instance of a given holiday before the current date object
- **until*HolidayName*()** function returning a `CarbonInterval` representing the time until the next instance of a given holiday after the current date object.
- **since*HolidayName*()** function returning a `CarbonInterval` representing the time since the last instance of a given holiday before the current date object.

There is also a generic **trekHoliday** macro that returns the string name of the current holiday if it _is_ a holiday and an **isTrekHoliday** that returns true if the current date object is _any_ of those holidays.

### Current Available Holidays
- **First Contact Day**: [April 5](https://memory-alpha.fandom.com/wiki/First_Contact_Day)
- **Star Trek Day**: [September 8](https://www.daysoftheyear.com/days/star-trek-day/), the anniversary of the first airing of Star Trek, CBS/Paramount+ often makes a big deal out of this day
- **Captain Picard Day**: [June 16](https://memory-alpha.fandom.com/wiki/Captain_Picard_Day)
- **Frontier Day**: [April 14](https://www.startrek.com/news/what-is-frontier-day).
  - This was tricky, we know it is in April, and that it celebrates the launching of the NX-01.  The specific date we get in Broken Bow is April 16, but the launch was at least a day earlier based on the position of that.  Startrek.com [mentioned](https://www.startrek.com/news/what-is-frontier-day) it with a post on April 14th, so we went with that date.
- **Ancestor's Eve**: [April 22](https://memory-alpha.fandom.com/wiki/Ancestors%27_Eve)

### Holiday Example

```php
$date = Carbon::parse("April 5, 2023");
$date->isFirstContactDay(); # true
$date->isStarTrekDay(); # false
$date->nextAncestorsEve(); # "April 22, 2023"
$date->untilNextAncestorsEve(); # "17 days"
$date->trekHoliday(); # "First Contact Day"
$date->isTrekHoliday(); # true

$date->addDays(2);
$date->trekHoliday(); # null
$date->isTrekHoliday(); # false
$date->sinceFirstContactDay(); # "2 days"
```