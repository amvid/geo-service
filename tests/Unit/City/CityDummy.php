<?php

declare(strict_types=1);

namespace App\Tests\Unit\City;

use App\City\Entity\City;
use App\Country\Entity\Country;
use App\State\Entity\State;
use App\Tests\Unit\Country\CountryDummy;
use App\Tests\Unit\State\StateDummy;
use Ramsey\Uuid\Uuid;

class CityDummy
{
    public const ID = '1619adc7-815e-4ead-aa02-27d64f9bc2f6';
    public const TITLE = 'California';
    public const LONGITUDE = -97;
    public const LATITUDE = 123;
    public const ALTITUDE = null;

    public static function get(?Country $country = null, ?State $state = null): City
    {
        if (!$country) {
            $country = CountryDummy::get();
        }

        if (!$state) {
            $state = StateDummy::get($country);
        }

        $cityId = Uuid::fromString(self::ID);
        $city = new City($cityId);
        $city
            ->setTitle(self::TITLE)
            ->setState($state)
            ->setCountry($country)
            ->setAltitude(self::ALTITUDE)
            ->setLatitude(self::LATITUDE)
            ->setLongitude(self::LONGITUDE)
            ->setCreatedAt();

        return $city;
    }
}
