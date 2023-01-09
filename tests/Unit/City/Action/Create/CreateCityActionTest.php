<?php

declare(strict_types=1);

namespace App\Tests\Unit\City\Action\Create;

use App\City\Action\Create\CreateCityAction;
use App\City\Action\Create\CreateCityActionRequest;
use App\City\Factory\CityFactoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Entity\Country;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Exception\StateNotFoundException;
use App\State\Repository\StateRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CreateCityActionTest extends TestCase
{
    private CityFactoryInterface $cityFactory;
    private CityRepositoryInterface $cityRepository;
    private StateRepositoryInterface $stateRepository;
    private CountryRepositoryInterface $countryRepository;

    private CreateCityActionRequest $request;

    private string $title = 'Riga';
    private string $countryIso2 = 'LV';
    private string $stateCode = 'RIX';

    protected function setUp(): void
    {
        $this->cityFactory = $this->getMockBuilder(CityFactoryInterface::class)->getMock();
        $this->cityRepository = $this->getMockBuilder(CityRepositoryInterface::class)->getMock();
        $this->stateRepository = $this->getMockBuilder(StateRepositoryInterface::class)->getMock();
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();

        $this->request = new CreateCityActionRequest();
        $this->request->title = $this->title;
        $this->request->countryIso2 = $this->countryIso2;
        $this->request->stateCode = $this->stateCode;
    }

    public function testShouldThrowCountryNotFoundExceptionIfNotFound(): void
    {
        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(null);

        $action = new CreateCityAction(
            $this->cityFactory,
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
            ->method('findByCode')
            ->with($this->stateCode)
            ->willReturn(null);

        $action = new CreateCityAction(
            $this->cityFactory,
            $this->cityRepository,
            $this->stateRepository,
            $this->countryRepository,
        );

        $this->expectException(StateNotFoundException::class);
        $this->expectExceptionMessage("State '$this->stateCode' not found.");

        $action->run($this->request);
    }

    public function testShouldCreateCityAndReturnAValidResponse(): void
    {

    }
}