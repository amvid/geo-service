<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Factory;

use App\Airport\Factory\AirportFactory;
use App\Airport\Factory\AirportFactoryInterface;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\Timezone\TimezoneDummy;
use PHPUnit\Framework\TestCase;

class AirportFactoryTest extends TestCase
{
    private AirportFactoryInterface $airportFactory;

    protected function setUp(): void
    {
        $this->airportFactory = new AirportFactory();
    }

    public function testShouldReturnANewAirport(): void
    {
        $city = CityDummy::get();
        $timezone = TimezoneDummy::get();
        $title = 'Test Title';
        $iata = 'TST';
        $icao = 'TEST';
        $longitude = 11.12;
        $latitude = 12.11;
        $altitude = 21;

        $actual = $this->airportFactory
            ->setTitle($title)
            ->setIata($iata)
            ->setIcao($icao)
            ->setCity($city)
            ->setTimezone($timezone)
            ->setLongitude($longitude)
            ->setLatitude($latitude)
            ->setAltitude($altitude)
            ->create();

        $this->assertEquals($title, $actual->getTitle());
        $this->assertEquals($icao, $actual->getIcao());
        $this->assertEquals($iata, $actual->getIata());
        $this->assertEquals($longitude, $actual->getLongitude());
        $this->assertEquals($altitude, $actual->getAltitude());
        $this->assertEquals($latitude, $actual->getLatitude());
        $this->assertEquals($timezone, $actual->getTimezone());
        $this->assertEquals($city, $actual->getCity());
    }
}