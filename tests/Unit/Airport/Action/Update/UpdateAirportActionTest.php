<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Action\Update;

use App\Airport\Action\Update\UpdateAirportAction;
use App\Airport\Action\Update\UpdateAirportActionRequest;
use App\Airport\Entity\Airport;
use App\Airport\Exception\AirportNotFoundException;
use App\Airport\Factory\AirportFactoryInterface;
use App\Airport\Repository\AirportRepositoryInterface;
use App\City\Exception\CityNotFoundException;
use App\City\Repository\CityRepositoryInterface;
use App\Tests\Unit\Airport\AirportDummy;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\Timezone\TimezoneDummy;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UpdateAirportActionTest extends TestCase
{
    private AirportFactoryInterface $factory;
    private AirportRepositoryInterface $airportRepository;
    private CityRepositoryInterface $cityRepository;
    private TimezoneRepositoryInterface $timezoneRepository;

    private UpdateAirportActionRequest $request;
    private UuidInterface $id;
    private string $iata = 'TST';
    private string $icao = 'TEST';
    private string $title = 'Test Airport';
    private string $cityTitle = 'New York';
    private float $longitude = 11.11;
    private float $latitude = 22.22;
    private int $altitude = 33;
    private string $timezone = 'Europe/Oslo';

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(AirportFactoryInterface::class)->getMock();
        $this->airportRepository = $this->getMockBuilder(AirportRepositoryInterface::class)->getMock();
        $this->cityRepository = $this->getMockBuilder(CityRepositoryInterface::class)->getMock();
        $this->timezoneRepository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();

        $this->id = Uuid::uuid4();

        $this->request = new UpdateAirportActionRequest();
        $this->request->id = $this->id;
        $this->request->timezone = $this->timezone;
        $this->request->iata = $this->iata;
        $this->request->icao = $this->icao;
        $this->request->title = $this->title;
        $this->request->cityTitle = $this->cityTitle;
        $this->request->longitude = $this->longitude;
        $this->request->latitude = $this->latitude;
        $this->request->altitude = $this->altitude;
    }

    public function testShouldThrowAirportNotFoundExceptionIfNotFound(): void
    {
        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(null);

        $action = new UpdateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->timezoneRepository,
        );

        $this->expectException(AirportNotFoundException::class);
        $this->expectExceptionMessage("Airport '{$this->id->toString()}' not found.");

        $action->run($this->request);
    }

    public function testShouldThrowCityNotFoundExceptionIfNotFound(): void
    {
        $airport = AirportDummy::get();

        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $this->cityRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->cityTitle)
            ->willReturn(null);

        $action = new UpdateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->timezoneRepository,
        );

        $this->expectException(CityNotFoundException::class);
        $this->expectExceptionMessage("City '$this->cityTitle' not found.");

        $action->run($this->request);
    }

    public function testShouldThrowTimezoneNotFoundExceptionIfNotFound(): void
    {
        $airport = AirportDummy::get();

        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $this->cityRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->cityTitle)
            ->willReturn(CityDummy::get());

        $this->timezoneRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->timezone)
            ->willReturn(null);

        $action = new UpdateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->timezoneRepository,
        );

        $this->expectException(TimezoneNotFoundException::class);
        $this->expectExceptionMessage("Timezone '$this->timezone' not found.");

        $action->run($this->request);
    }

    public function testShouldReturnAValidResponse(): void
    {
        $airport = new Airport($this->id);
        $airport
            ->setTitle($this->title)
            ->setIcao($this->icao)
            ->setIata($this->iata)
            ->setLongitude($this->longitude)
            ->setAltitude($this->altitude)
            ->setLatitude($this->latitude);

        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $city = CityDummy::get();
        $this->cityRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->cityTitle)
            ->willReturn($city);

        $timezone = TimezoneDummy::get();
        $this->timezoneRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->timezone)
            ->willReturn($timezone);

        $airport
            ->setCity($city)
            ->setTimezone($timezone);

        $this->factory->expects($this->once())->method('setLongitude')->with($this->longitude)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setAltitude')->with($this->altitude)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setLatitude')->with($this->latitude)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setTitle')->with($this->title)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setCity')->with($city)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setTimezone')->with($timezone)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setIata')->with($this->iata)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setIcao')->with($this->icao)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('create')->with()->willReturn($airport);

        $this->airportRepository
            ->expects($this->once())
            ->method('save')
            ->with($airport, true);

        $action = new UpdateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->timezoneRepository,
        );

        $actual = $action->run($this->request);

        $this->assertEquals($airport->getTitle(), $actual->airport->title);
        $this->assertEquals($airport->getIata(), $actual->airport->iata);
        $this->assertEquals($airport->getIcao(), $actual->airport->icao);
        $this->assertEquals($airport->getLatitude(), $actual->airport->latitude);
        $this->assertEquals($airport->getAltitude(), $actual->airport->altitude);
        $this->assertEquals($airport->getLongitude(), $actual->airport->longitude);
        $this->assertEquals($this->id, $actual->airport->id);
        $this->assertEquals(CityDummy::ID, $actual->airport->city->id);
        $this->assertEquals(TimezoneDummy::ID, $actual->airport->timezone->id);
    }
}