<?php

declare(strict_types=1);

namespace App\Application\Command\Import;

class Config
{
    public static function getGeoDataFilepath(): string
    {
        return getcwd() . '/data/regions_countries_timezones_currencies.json';
    }

    public static function getStatesDataFilepath(): string
    {
        return getcwd() . '/data/states.json';
    }

    public static function getCitiesDataFilepath(): string
    {
        return getcwd() . '/data/airports_and_cities.csv';
    }

    public static function getAirportsDataFilepath(): string
    {
        return getcwd() . '/data/airports_and_cities.csv';
    }
}