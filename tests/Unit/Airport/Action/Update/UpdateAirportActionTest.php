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
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\Tests\Unit\Airport\AirportDummy;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\Country\CountryDummy;
use App\Tests\Unit\Timezone\TimezoneDummy;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UpdateAirportActionTest extends TestCase
{
    private AirportFactoryInterface&MockObject $factory;
    private AirportRepositoryInterface&MockObject $airportRepository;
    private CityRepositoryInterface&MockObject $cityRepository;
    private CountryRepositoryInterface&MockObject $countryRepository;
    private TimezoneRepositoryInterface&MockObject $timezoneRepository;

    private UpdateAirportActionRequest $request;
    private UuidInterface $id;
    private string $countryIso2 = 'US';
    private string $iata = 'TST';
    private string $icao = 'TEST';
    private string $title = 'Test Airport';
    private string $cityTitle = 'New York';
    private float $longitude = 11.11;
    private float $latitude = 22.22;
    private int $altitude = 33;
    private string $timezone = 'Europe/Oslo';
    private bool $isActive = true;

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(AirportFactoryInterface::class)->getMock();
        $this->airportRepository = $this->getMockBuilder(AirportRepositoryInterface::class)->getMock();
        $this->cityRepository = $this->getMockBuilder(CityRepositoryInterface::class)->getMock();
        $this->timezoneRepository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();

        $this->id = Uuid::uuid4();

        $this->request = new UpdateAirportActionRequest();
        $this->request->countryIso2 = $this->countryIso2;
        $this->request->timezone = $this->timezone;
        $this->request->iata = $this->iata;
        $this->request->icao = $this->icao;
        $this->request->title = $this->title;
        $this->request->cityTitle = $this->cityTitle;
        $this->request->longitude = $this->longitude;
        $this->request->latitude = $this->latitude;
        $this->request->altitude = $this->altitude;
        $this->request->isActive = $this->isActive;
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
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(AirportNotFoundException::class);
        $this->expectExceptionMessage("Airport '{$this->id->toString()}' not found.");

        $action->run($this->request, $this->id);
    }

    public function testShouldThrowBadRequestExceptionIfCountryIso2NotPassedWithCity(): void
    {
        $airport = AirportDummy::get();

        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $this->request->countryIso2 = null;

        $action = new UpdateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage("Country ISO2 is required when updating city title");

        $action->run($this->request, $this->id);
    }

    public function testShouldThrowCountryNotFoundExceptionIfNotFound(): void
    {
        $airport = AirportDummy::get();

        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(null);

        $action = new UpdateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(CountryNotFoundException::class);
        $this->expectExceptionMessage("Country '$this->countryIso2' not found.");

        $action->run($this->request, $this->id);
    }

    public function testShouldThrowCityNotFoundExceptionIfNotFound(): void
    {
        $airport = AirportDummy::get();

        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $country = CountryDummy::get();

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $this->cityRepository
            ->expects($this->once())
            ->method('findByTitleAndCountry')
            ->with($this->cityTitle, $country)
            ->willReturn(null);

        $action = new UpdateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(CityNotFoundException::class);
        $this->expectExceptionMessage("City '$this->cityTitle' not found.");

        $action->run($this->request, $this->id);
    }

    public function testShouldThrowTimezoneNotFoundExceptionIfNotFound(): void
    {
        $airport = AirportDummy::get();

        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $country = CountryDummy::get();

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $this->cityRepository
            ->expects($this->once())
            ->method('findByTitleAndCountry')
            ->with($this->cityTitle, $country)
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
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(TimezoneNotFoundException::class);
        $this->expectExceptionMessage("Timezone '$this->timezone' not found.");

        $action->run($this->request, $this->id);
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
            ->setLatitude($this->latitude)
            ->setIsActive($this->isActive);

        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $country = CountryDummy::get();
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $city = CityDummy::get();
        $this->cityRepository
            ->expects($this->once())
            ->method('findByTitleAndCountry')
            ->with($this->cityTitle, $country)
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

        $this->factory
            ->expects($this->once())->method('setLongitude')->with($this->longitude)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setAltitude')->with($this->altitude)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setLatitude')->with($this->latitude)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setTitle')->with($this->title)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setCity')->with($city)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setTimezone')->with($timezone)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setIata')->with($this->iata)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setIcao')->with($this->icao)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setIsActive')->with($this->isActive)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('create')->with()->willReturn($airport);

        $this->airportRepository
            ->expects($this->once())
            ->method('save')
            ->with($airport, true);

        $action = new UpdateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $actual = $action->run($this->request, $this->id);

        $this->assertEquals($airport->getTitle(), $actual->airport->title);
        $this->assertEquals($airport->getIata(), $actual->airport->iata);
        $this->assertEquals($airport->getIcao(), $actual->airport->icao);
        $this->assertEquals($airport->getLatitude(), $actual->airport->latitude);
        $this->assertEquals($airport->getAltitude(), $actual->airport->altitude);
        $this->assertEquals($airport->getLongitude(), $actual->airport->longitude);
        $this->assertEquals($airport->isActive(), $actual->airport->isActive);
        $this->assertEquals($this->id, $actual->airport->id);
        $this->assertEquals(CityDummy::ID, $actual->airport->city->id);
        $this->assertEquals(TimezoneDummy::ID, $actual->airport->timezone->id);
    }
}
