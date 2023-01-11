<?php

declare(strict_types=1);

namespace App\Tests\Unit\City\Factory;

use App\City\Factory\CityFactory;
use App\City\Factory\CityFactoryInterface;
use App\Country\Entity\Country;
use App\State\Entity\State;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CityFactoryTest extends TestCase
{
    private CityFactoryInterface $cityFactory;

    protected function setUp(): void
    {
        $this->cityFactory = new CityFactory();
    }

    public function testShouldReturnANewCity(): void
    {
        $countryId = Uuid::uuid4();
        $country = new Country($countryId);

        $stateId = Uuid::uuid4();
        $state = new State($stateId);

        $title = 'Trondheim';
        $longitude = 11.12;
        $latitude = 12.11;
        $altitude = 21;

        $actual = $this->cityFactory
            ->setTitle($title)
            ->setCountry($country)
            ->setState($state)
            ->setLongitude($longitude)
            ->setLatitude($latitude)
            ->setAltitude($altitude)
            ->create();

        $this->assertEquals($title, $actual->getTitle());
        $this->assertEquals($longitude, $actual->getLongitude());
        $this->assertEquals($altitude, $actual->getAltitude());
        $this->assertEquals($latitude, $actual->getLatitude());
        $this->assertEquals($countryId, $actual->getCountry()->getId());
        $this->assertEquals($stateId, $actual->getState()->getId());
    }
}