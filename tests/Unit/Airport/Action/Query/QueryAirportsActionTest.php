<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Action\Query;

use App\Airport\Action\Query\QueryAirportsAction;
use App\Airport\Action\Query\QueryAirportsActionRequest;
use App\Airport\Repository\AirportRepositoryInterface;
use App\Tests\Unit\Airport\AirportDummy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class QueryAirportsActionTest extends TestCase
{
    private AirportRepositoryInterface&MockObject $airportRepository;
    private QueryAirportsActionRequest $request;

    private int $offset = 0;
    private int $limit = 10;
    private string $query = 'London';

    protected function setUp(): void
    {
        $this->airportRepository = $this->getMockBuilder(AirportRepositoryInterface::class)->getMock();
        $this->request = new QueryAirportsActionRequest();
        $this->request->offset = $this->offset;
        $this->request->limit = $this->limit;
        $this->request->query = $this->query;
    }

    public function testShouldReturnEmptyArrayIfNoAirportsFound(): void
    {
        $this->airportRepository
            ->expects($this->once())
            ->method('query')
            ->willReturn([]);

        $action = new QueryAirportsAction($this->airportRepository);
        $response = $action->run($this->request);

        $this->assertEmpty($response->airports);
    }

    public function testShouldReturnAirports(): void
    {
        $airport = AirportDummy::get();

        $this->airportRepository
            ->expects($this->once())
            ->method('query')
            ->willReturn([$airport]);

        $action = new QueryAirportsAction($this->airportRepository);
        $response = $action->run($this->request);

        $city = $airport->getCity();
        $country = $city->getCountry();
        $subregion = $country->getSubregion();
        $region = $subregion->getRegion();
        $timezone = $airport->getTimezone();

        $this->assertCount(1, $response->airports);
        $this->assertEquals($airport->getTitle(), $response->airports[0]->title);
        $this->assertEquals($airport->getIata(), $response->airports[0]->iata);
        $this->assertEquals($city->getTitle(), $response->airports[0]->city);
        $this->assertEquals($country->getTitle(), $response->airports[0]->country);
        $this->assertEquals($subregion->getTitle(), $response->airports[0]->subregion);
        $this->assertEquals($region->getTitle(), $response->airports[0]->region);
        $this->assertEquals($timezone->getCode(), $response->airports[0]->timezone);
    }
}
