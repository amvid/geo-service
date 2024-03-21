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

        $children = new QueryAirportResponse(
            $airport->getTitle(),
            $airport->getIata(),
            $airport->getCity()->getCountry()->getTitle()
        );

        $actual = new QueryChildrenAirportResponse(
            $airport->getTitle(),
            $airport->getIata(),
            $airport->getCity()->getCountry()->getTitle(),
            [$children]
        );

        $this->assertEquals($airport->getTitle(), $actual->title);
        $this->assertEquals($airport->getIata(), $actual->iata);
        $this->assertEquals($airport->getCity()->getCountry()->getTitle(), $actual->country);

        $this->assertEquals($airport->getTitle(), $actual->children[0]->title);
        $this->assertEquals($airport->getIata(), $actual->children[0]->iata);
        $this->assertEquals($airport->getCity()->getCountry()->getTitle(), $actual->children[0]->country);
    }
}
