<?php

declare(strict_types=1);

namespace App\Command\Import;

class ImportConfig
{
    public static function getGeoDataFilepath(): string
    {
        return getcwd() . '/data/regions_countries_timezones_currencies.json';
    }
}