<?php

declare(strict_types=1);

namespace App\Tests\Unit\City\Action\Create;

use App\City\Action\Create\CreateCityAction;
use App\City\Action\Create\CreateCityActionRequest;
use App\City\Entity\City;
use App\City\Exception\CityAlreadyExistsException;
use App\City\Factory\CityFactoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Entity\Country;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Exception\StateNotFoundException;
use App\State\Repository\StateRepositoryInterface;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\Country\CountryDummy;
use App\Tests\Unit\State\StateDummy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateCityActionTest extends TestCase
{
    private CityFactoryInterface&MockObject $factory;
    private CityRepositoryInterface&MockObject $cityRepository;
    private StateRepositoryInterface&MockObject $stateRepository;
    private CountryRepositoryInterface&MockObject $countryRepository;

    private CreateCityActionRequest $request;

    private string $title = 'Riga';
    private string $iata = 'RIX';
    private string $countryIso2 = 'LV';
    private string $stateTitle = 'RIX';
    private float $longitude = 55.12;
    private float $latitude = 10.0;
    private int $altitude = 1;

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(CityFactoryInterface::class)->getMock();
        $this->cityRepository = $this->getMockBuilder(CityRepositoryInterface::class)->getMock();
        $this->stateRepository = $this->getMockBuilder(StateRepositoryInterface::class)->getMock();
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();

        $this->request = new CreateCityActionRequest();
        $this->request->title = $this->title;
        $this->request->iata = $this->iata;
        $this->request->countryIso2 = $this->countryIso2;
        $this->request->stateTitle = $this->stateTitle;
        $this->request->latitude = $this->latitude;
        $this->request->altitude = $this->altitude;
        $this->request->longitude = $this->longitude;
    }

    public function testShouldThrowCountryNotFoundExceptionIfNotFound(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(null);

        $action = new CreateCityAction(
            $this->factory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository,
        );

        $this->expectException(CountryNotFoundException::class);
        $this->expectExceptionMessage("Country '$this->countryIso2' not found.");
        $action->run($this->request);
    }

    public function testShouldThrowStateNotFoundExceptionIfNotFound(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(new Country());

        $this->stateRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->stateTitle)
            ->willReturn(null);

        $action = new CreateCityAction(
            $this->factory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository,
        );

        $this->expectException(StateNotFoundException::class);
        $this->expectExceptionMessage("State '$this->stateTitle' not found.");

        $action->run($this->request);
    }

    public function testShouldThrowCityAlreadyExistsExceptionIfIataAlreadyInUse(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(new Country());

        $this->cityRepository
            ->expects($this->once())
            ->method('findByIata')
            ->with($this->iata)
            ->willReturn(new City());

        $action = new CreateCityAction(
            $this->factory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository,
        );

        $this->expectException(CityAlreadyExistsException::class);
        $this->expectExceptionMessage("City '$this->iata' already exists.");

        $action->run($this->request, Uuid::fromString(CityDummy::ID));
    }

    public function testShouldCreateCityAndReturnAValidResponse(): void
    {
        $country = CountryDummy::get();
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $state = StateDummy::get($country);
        $this->stateRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->stateTitle)
            ->willReturn($state);

        $city = new City(Uuid::fromString(CityDummy::ID));
        $city
            ->setState($state)
            ->setCountry($country)
            ->setLatitude($this->latitude)
            ->setLongitude($this->longitude)
            ->setAltitude($this->altitude)
            ->setTitle($this->title);

        $this->factory->expects($this->once())->method('setTitle')->with($this->title)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setLongitude')->with($this->longitude)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setLatitude')->with($this->latitude)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setAltitude')->with($this->altitude)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setCountry')->with($country)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setState')->with($state)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('create')->willReturn($city);

        $this->cityRepository
            ->expects($this->once())
            ->method('save', true)
            ->with($city);

        $action = new CreateCityAction(
            $this->factory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository
        );

        $actual = $action->run($this->request);

        $this->assertEquals($this->title, $actual->city->title);
    }
}
