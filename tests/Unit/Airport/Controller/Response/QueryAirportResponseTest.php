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

        $country = $airport->getCity()->getCountry();
        $subregion = $country->getSubregion();
        $region = $subregion->getRegion();

        $actual = new QueryAirportResponse(
            $airport->getTitle(),
            $airport->getIata(),
            $airport->getCity()->getCountry()->getTitle(),
            $region->getTitle(),
            $subregion->getTitle(),
        );

        $this->assertEquals($airport->getTitle(), $actual->title);
        $this->assertEquals($airport->getIata(), $actual->iata);
        $this->assertEquals($airport->getCity()->getCountry()->getTitle(), $actual->country);
    }
}
