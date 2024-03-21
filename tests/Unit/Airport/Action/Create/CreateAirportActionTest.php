<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Action\Create;

use App\Airport\Action\Create\CreateAirportAction;
use App\Airport\Action\Create\CreateAirportActionRequest;
use App\Airport\Entity\Airport;
use App\Airport\Exception\AirportAlreadyExistsException;
use App\Airport\Factory\AirportFactoryInterface;
use App\Airport\Repository\AirportRepositoryInterface;
use App\City\Entity\City;
use App\Country\Entity\Country;
use App\City\Exception\CityNotFoundException;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\Country\CountryDummy;
use App\Tests\Unit\Timezone\TimezoneDummy;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateAirportActionTest extends TestCase
{
    private AirportFactoryInterface $factory;
    private AirportRepositoryInterface $airportRepository;
    private CityRepositoryInterface $cityRepository;
    private CountryRepositoryInterface $countryRepository;
    private TimezoneRepositoryInterface $timezoneRepository;

    private CreateAirportActionRequest $request;
    private string $iata = 'TST';
    private string $countryIso2 = 'US';
    private string $icao = 'TEST';
    private string $title = 'Test Airport';
    private string $cityTitle = CityDummy::TITLE;
    private float $longitude = 11.11;
    private float $latitude = 22.22;
    private int $altitude = 33;
    private string $timezone = TimezoneDummy::CODE;

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(AirportFactoryInterface::class)->getMock();
        $this->airportRepository = $this->getMockBuilder(AirportRepositoryInterface::class)->getMock();
        $this->cityRepository = $this->getMockBuilder(CityRepositoryInterface::class)->getMock();
        $this->timezoneRepository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();

        $this->request = new CreateAirportActionRequest();
        $this->request->countryIso2 = $this->countryIso2;;
        $this->request->timezone = $this->timezone;
        $this->request->iata = $this->iata;
        $this->request->icao = $this->icao;
        $this->request->title = $this->title;
        $this->request->cityTitle = $this->cityTitle;
        $this->request->longitude = $this->longitude;
        $this->request->latitude = $this->latitude;
        $this->request->altitude = $this->altitude;
    }

    public function testShouldThrowAirportAlreadyExistsExceptionIfExists(): void
    {
        $this->airportRepository
            ->expects($this->once())
            ->method('findByIata')
            ->with($this->iata)
            ->willReturn(new Airport());

        $action = new CreateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(AirportAlreadyExistsException::class);
        $this->expectExceptionMessage('Airport already exists.');

        $action->run($this->request);
    }

    public function testShouldThrowCountryNotFoundExceptionIfNotFound(): void
    {
        $this->airportRepository
            ->expects($this->once())
            ->method('findByIata')
            ->with($this->iata)
            ->willReturn(null);

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(null);

        $action = new CreateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(CountryNotFoundException::class);
        $this->expectExceptionMessage("Country '$this->countryIso2' not found.");

        $action->run($this->request);
    }

    public function testShouldThrowCityNotFoundExceptionIfNotFound(): void
    {
        $country = CountryDummy::get();
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $this->airportRepository
            ->expects($this->once())
            ->method('findByIata')
            ->with($this->iata)
            ->willReturn(null);

        $this->cityRepository
            ->expects($this->once())
            ->method('findByTitleAndCountry')
            ->with($this->cityTitle, $country)
            ->willReturn(null);

        $action = new CreateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(CityNotFoundException::class);
        $this->expectExceptionMessage("City '$this->cityTitle' not found.");

        $action->run($this->request);
    }

    public function testShouldThrowTimezoneNotFoundExceptionIfNotFound(): void
    {
        $this->airportRepository
            ->expects($this->once())
            ->method('findByIata')
            ->with($this->iata)
            ->willReturn(null);

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
            ->willReturn(new City());

        $this->timezoneRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->timezone)
            ->willReturn(null);

        $action = new CreateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $this->expectException(TimezoneNotFoundException::class);
        $this->expectExceptionMessage("Timezone '$this->timezone' not found.");

        $action->run($this->request);
    }

    public function testShouldReturnAValidResponse(): void
    {
        $country = CountryDummy::get();

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $this->airportRepository
            ->expects($this->once())
            ->method('findByIata')
            ->with($this->iata)
            ->willReturn(null);

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

        $airportId = Uuid::uuid4();
        $airport = new Airport($airportId);
        $airport
            ->setCity($city)
            ->setTimezone($timezone)
            ->setTitle($this->title)
            ->setIcao($this->icao)
            ->setIata($this->iata)
            ->setLongitude($this->longitude)
            ->setAltitude($this->altitude)
            ->setLatitude($this->latitude);

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
        $this->factory->expects($this->once())->method('create')->with()->willReturn($airport);

        $this->airportRepository
            ->expects($this->once())
            ->method('save')
            ->with($airport, true);

        $action = new CreateAirportAction(
            $this->factory,
            $this->airportRepository,
            $this->cityRepository,
            $this->countryRepository,
            $this->timezoneRepository,
        );

        $actual = $action->run($this->request);

        $this->assertEquals($airport->getTitle(), $actual->airport->title);
        $this->assertEquals($airport->getIata(), $actual->airport->iata);
        $this->assertEquals($airport->getIcao(), $actual->airport->icao);
        $this->assertEquals($airport->getLatitude(), $actual->airport->latitude);
        $this->assertEquals($airport->getAltitude(), $actual->airport->altitude);
        $this->assertEquals($airport->getLongitude(), $actual->airport->longitude);
        $this->assertEquals($airportId, $actual->airport->id);
        $this->assertEquals(CityDummy::ID, $actual->airport->city->id);
        $this->assertEquals(TimezoneDummy::ID, $actual->airport->timezone->id);
    }
}
