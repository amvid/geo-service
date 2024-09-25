<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Controller\Response;

use App\Airport\Controller\Response\QueryAirportResponse;
use App\Airport\Controller\Response\QueryChildrenAirportResponse;
use App\Tests\Unit\Airport\AirportDummy;
use PHPUnit\Framework\TestCase;

class QueryChildrenAirportResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $airport = AirportDummy::get();
        $city = $airport->getCity();
        $country = $city->getCountry();
        $subregion = $country->getSubregion();
        $region = $subregion->getRegion();
        $timezone = $airport->getTimezone();

        $children = new QueryAirportResponse(
            $airport->getTitle(),
            $airport->getIata(),
            $city->getTitle(),
            $country->getTitle(),
            $timezone->getCode(),
            $region->getTitle(),
            $subregion->getTitle(),
        );

        $actual = new QueryChildrenAirportResponse(
            $airport->getTitle(),
            $airport->getIata(),
            $city->getTitle(),
            $country->getTitle(),
            $timezone->getCode(),
            $region->getTitle(),
            $subregion->getTitle(),
            [$children]
        );

        $this->assertEquals($airport->getTitle(), $actual->title);
        $this->assertEquals($airport->getIata(), $actual->iata);
        $this->assertEquals($city->getTitle(), $actual->city);
        $this->assertEquals($country->getTitle(), $actual->country);
        $this->assertEquals($timezone->getCode(), $actual->timezone);
        $this->assertEquals($region->getTitle(), $actual->region);
        $this->assertEquals($subregion->getTitle(), $actual->subregion);

        $this->assertEquals($airport->getTitle(), $actual->children[0]->title);
        $this->assertEquals($airport->getIata(), $actual->children[0]->iata);
        $this->assertEquals($city->getTitle(), $actual->children[0]->city);
        $this->assertEquals($country->getTitle(), $actual->children[0]->country);
    }
}
