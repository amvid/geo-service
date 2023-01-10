<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport;

use App\Airport\Entity\Airport;
use App\City\Entity\City;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\Timezone\TimezoneDummy;
use App\Timezone\Entity\Timezone;
use Ramsey\Uuid\Uuid;

class AirportDummy
{
    public const ID = '1f21557e-f115-4d21-bab1-f401ddc78a62';
    public const TITLE = 'Anaa';
    public const ICAO = 'NTGA';
    public const IATA = 'AAA';

    public static function get(?Timezone $timezone = null, ?City $city = null): Airport
    {
        if (!$timezone) {
            $timezone = TimezoneDummy::get();
        }

        if (!$city) {
            $city = CityDummy::get();
        }

        $airport = new Airport(Uuid::fromString(self::ID));
        $airport
            ->setTitle(self::TITLE)
            ->setIcao(self::ICAO)
            ->setIata(self::IATA)
            ->setTimezone($timezone)
            ->setCity($city)
            ->setCreatedAt();

        return $airport;
    }
}