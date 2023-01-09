<?php

namespace App\Tests\Unit\State;

use App\Country\Entity\Country;
use App\State\Entity\State;
use App\Tests\Unit\Country\CountryDummy;
use Ramsey\Uuid\Uuid;

class StateDummy
{
    public const ID = '1c26098d-cd63-47f5-9dd1-59a299b8288b';
    public const CODE = 'NJ';
    public const TITLE = 'New Jersey';
    public const TYPE = 'state';
    public const LONGITUDE = 10.5;
    public const LATITUDE = 55.2;
    public const ALTITUDE = 10;

    public static function get(?Country $country = null): State
    {
        if (!$country) {
            $country = CountryDummy::get();
        }

        $stateId = Uuid::uuid4();
        $state = new State($stateId);
        $state
            ->setCountry($country)
            ->setCode(self::CODE)
            ->setType(self::TYPE)
            ->setTitle(self::TITLE)
            ->setLongitude(self::LONGITUDE)
            ->setLatitude(self::LATITUDE)
            ->setAltitude(self::ALTITUDE)
            ->setCreatedAt();

        return $state;
    }
}