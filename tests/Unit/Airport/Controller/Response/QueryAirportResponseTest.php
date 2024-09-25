<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Controller\Response;

use App\Airport\Controller\Response\QueryAirportResponse;
use App\Tests\Unit\Airport\AirportDummy;
use PHPUnit\Framework\TestCase;

class QueryAirportResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $airport = AirportDummy::get();

        $city = $airport->getCity();
        $country = $city->getCountry();
        $subregion = $country->getSubregion();
        $region = $subregion->getRegion();
        $timezone = $airport->getTimezone();

        $actual = new QueryAirportResponse(
            $airport->getTitle(),
            $airport->getIata(),
            $city->getTitle(),
            $country->getTitle(),
            $timezone->getCode(),
            $region->getTitle(),
            $subregion->getTitle(),
        );

        $this->assertEquals($airport->getTitle(), $actual->title);
        $this->assertEquals($airport->getIata(), $actual->iata);
        $this->assertEquals($city->getTitle(), $actual->city);
        $this->assertEquals($country->getTitle(), $actual->country);
        $this->assertEquals($timezone->getCode(), $actual->timezone);
        $this->assertEquals($subregion->getTitle(), $actual->subregion);
        $this->assertEquals($region->getTitle(), $actual->region);
    }
}
