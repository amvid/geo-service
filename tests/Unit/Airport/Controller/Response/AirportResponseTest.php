<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Controller\Response;

use App\Airport\Controller\Response\AirportResponse;
use App\Tests\Unit\Airport\AirportDummy;
use PHPUnit\Framework\TestCase;

class AirportResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $airport = AirportDummy::get();
        $actual = new AirportResponse($airport);

        $this->assertEquals($airport->getId(), $actual->id);
        $this->assertEquals($airport->getIata(), $actual->iata);
        $this->assertEquals($airport->getIcao(), $actual->icao);
        $this->assertEquals($airport->getTitle(), $actual->title);
        $this->assertEquals($airport->getLongitude(), $actual->longitude);
        $this->assertEquals($airport->getLatitude(), $actual->latitude);
        $this->assertEquals($airport->getAltitude(), $actual->altitude);
        $this->assertEquals($airport->getTimezone()->getId(), $actual->timezone->id);
        $this->assertEquals($airport->getCity()->getId(), $actual->city->id);
    }
}
