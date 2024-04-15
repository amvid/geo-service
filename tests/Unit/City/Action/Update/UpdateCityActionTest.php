<?php

declare(strict_types=1);

namespace App\Tests\Unit\City\Action\Update;

use App\City\Action\Update\UpdateCityAction;
use App\City\Action\Update\UpdateCityActionRequest;
use App\City\Exception\CityNotFoundException;
use App\City\Factory\CityFactoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Exception\StateNotFoundException;
use App\State\Repository\StateRepositoryInterface;
use App\Tests\Unit\City\CityDummy;
use App\Tests\Unit\State\StateDummy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateCityActionTest extends TestCase
{
    private CityFactoryInterface&MockObject $factory;
    private CityRepositoryInterface&MockObject $cityRepository;
    private StateRepositoryInterface&MockObject $stateRepository;
    private CountryRepositoryInterface&MockObject $countryRepository;

    private UpdateCityActionRequest $request;

    private string $title = 'California';
    private string $iata = 'TST';
    private string $countryIso2 = 'US';
    private string $stateTitle = 'New Jersey';
    private float $latitude = 10.10;
    private float $longitude = 12.12;
    private int $altitude = 10;

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(CityFactoryInterface::class)->getMock();
        $this->cityRepository = $this->getMockBuilder(CityRepositoryInterface::class)->getMock();
        $this->stateRepository = $this->getMockBuilder(StateRepositoryInterface::class)->getMock();
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();

        $this->request = new UpdateCityActionRequest();
        $this->request->title = $this->title;
        $this->request->iata = $this->iata;
        $this->request->stateTitle = $this->stateTitle;
        $this->request->countryIso2 = $this->countryIso2;
        $this->request->latitude = $this->latitude;
        $this->request->longitude = $this->longitude;
        $this->request->altitude = $this->altitude;
    }

    public function testShouldThrowCityNotFoundExceptionIfNotFound(): void
    {
        $this->cityRepository
            ->expects($this->once())
            ->method('findById')
            ->with(Uuid::fromString(CityDummy::ID))
            ->willReturn(null);

        $action = new UpdateCityAction(
            $this->factory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository,
        );

        $this->expectException(CityNotFoundException::class);
        $this->expectExceptionMessage('City \'' . CityDummy::ID . '\' not found.');

        $action->run($this->request, Uuid::fromString(CityDummy::ID));
    }

    public function testShouldThrowCityAlreadyExistsExceptionIfIataAlreadyInUse(): void
    {
        $this->cityRepository
            ->expects($this->once())
            ->method('findById')
            ->with(Uuid::fromString(CityDummy::ID))
            ->willReturn(CityDummy::get());

        $this->cityRepository
            ->expects($this->once())
            ->method('findByIata')
            ->with($this->iata)
            ->willReturn(null);

        $action = new UpdateCityAction(
            $this->factory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository,
        );

        $this->expectException(StateNotFoundException::class);
        $this->expectExceptionMessage("State '$this->stateTitle' not found.");

        $action->run($this->request, Uuid::fromString(CityDummy::ID));
    }

    public function testShouldThrowStateNotFoundExceptionIfNotFound(): void
    {
        $this->cityRepository
            ->expects($this->once())
            ->method('findById')
            ->with(Uuid::fromString(CityDummy::ID))
            ->willReturn(CityDummy::get());

        $this->stateRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->stateTitle)
            ->willReturn(null);

        $action = new UpdateCityAction(
            $this->factory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository,
        );

        $this->expectException(StateNotFoundException::class);
        $this->expectExceptionMessage("State '$this->stateTitle' not found.");

        $action->run($this->request, Uuid::fromString(CityDummy::ID));
    }

    public function testShouldThrowCountryNotFoundExceptionIfNotFound(): void
    {
        $this->cityRepository
            ->expects($this->once())
            ->method('findById')
            ->with(Uuid::fromString(CityDummy::ID))
            ->willReturn(CityDummy::get());

        $this->stateRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->stateTitle)
            ->willReturn(StateDummy::get());

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(null);

        $action = new UpdateCityAction(
            $this->factory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository,
        );

        $this->expectException(CountryNotFoundException::class);
        $this->expectExceptionMessage("Country '$this->countryIso2' not found.");

        $action->run($this->request, Uuid::fromString(CityDummy::ID));
    }
}
