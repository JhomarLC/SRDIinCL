<?php
namespace App\Helpers;

use Illuminate\Support\Carbon;

class SeasonHelper
{
    /**
     * Generate an array of “year options” from $startYear up to the current year.
     *
     * @param  int    $startYear   e.g. 2021
     * @param  string $season      'dry-season' or anything else
     * @return array               [ value => label, … ]
     */
    public static function yearOptions(int $startYear, string $season): array
    {
        $currentYear = Carbon::now()->year;
        $opts = [];

        if ($season === 'dry-season') {
            // dry‐season spans two calendar years: 2021-2022, 2022-2023, … up to (current-1)-(current)
            for ($y = $startYear; $y < $currentYear; $y++) {
                $label = $y . '-' . ($y + 1);
                $opts[$label] = $label;
            }
        } else {
            // wet‐season (or default) is just single years: 2021, 2022, … up to current
            for ($y = $startYear; $y <= $currentYear; $y++) {
                $opts[(string) $y] = (string) $y;
            }
        }

        return $opts;
    }
}
