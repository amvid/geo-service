<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Entity;

use App\Airport\Entity\Airport;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\Timezone\TimezoneDummy;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AirportTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $timezone = TimezoneDummy::get();
        $city = CityDummy::get();

        $airportId = Uuid::uuid4();
        $icao = 'NTGA';
        $iata = 'AAA';
        $title = 'Anaa';

        $airport = new Airport($airportId);
        $airport
            ->setTitle('Anaa')
            ->setIata('AAA')
            ->setIcao('NTGA')
            ->setTimezone($timezone)
            ->setCity($city)
            ->setCreatedAt();

        $this->assertEquals($airportId, $airport->getId());
        $this->assertEquals($icao, $airport->getIcao());
        $this->assertEquals($iata, $airport->getIata());
        $this->assertEquals($title, $airport->getTitle());
        $this->assertEquals($timezone, $airport->getTimezone());
        $this->assertEquals($city, $airport->getCity());
    }
}