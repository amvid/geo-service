<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Action\Update;

use App\Country\Entity\Country;
use App\Country\Repository\CountryRepositoryInterface;
use App\Currency\Entity\Currency;
use App\Region\Entity\Region;
use App\State\Action\Update\UpdateStateAction;
use App\State\Action\Update\UpdateStateActionRequest;
use App\State\Entity\State;
use App\State\Exception\StateNotFoundException;
use App\State\Factory\StateFactoryInterface;
use App\State\Repository\StateRepositoryInterface;
use App\SubRegion\Entity\SubRegion;
use App\Timezone\Entity\Timezone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UpdateStateActionTest extends TestCase
{
    private StateFactoryInterface $stateFactory;
    private StateRepositoryInterface $stateRepository;
    private CountryRepositoryInterface $countryRepository;

    private UpdateStateActionRequest $request;
    private UuidInterface $id;
    private string $title;
    private float $longitude;
    private float $latitude;
    private int $altitude;
    private string $type;
    private string $countryIso2;

    protected function setUp(): void
    {
        $this->stateRepository = $this->getMockBuilder(StateRepositoryInterface::class)->getMock();
        $this->stateFactory = $this->getMockBuilder(StateFactoryInterface::class)->getMock();
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();

        $this->id = Uuid::uuid4();
        $this->title = 'New Jersey';
        $this->longitude = 11.1;
        $this->latitude = 15.1;
        $this->altitude = 10;
        $this->type = 'state';
        $this->countryIso2 = 'US';

        $this->request = new UpdateStateActionRequest();
        $this->request->id = $this->id;
        $this->request->title = $this->title;
        $this->request->longitude = $this->longitude;
        $this->request->latitude = $this->latitude;
        $this->request->altitude = $this->altitude;
        $this->request->type = $this->type;
        $this->request->countryIso2 = $this->countryIso2;
    }

    public function testShouldThrowStateNotFoundExceptionIfNotExists(): void
    {
        $this->stateRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(null);

        $action = new UpdateStateAction($this->countryRepository, $this->stateRepository, $this->stateFactory);

        $this->expectException(StateNotFoundException::class);
        $this->expectExceptionMessage("State '$this->id' not found.");
        $action->run($this->request);
    }

    public function testShouldReturnNewUpdateStateResponse(): void
    {
        $regionId = Uuid::uuid4();
        $region = new Region($regionId);
        $region->setTitle('Americas')->setCreatedAt();

        $subRegionId = Uuid::uuid4();
        $subRegion = new SubRegion($subRegionId);
        $subRegion
            ->setRegion($region)
            ->setTitle('Northern Americas')
            ->setCreatedAt();

        $currencyId = Uuid::uuid4();
        $currency = new Currency($currencyId);
        $currency
            ->setCode('USD')
            ->setName('United States Dollar')
            ->setSymbol('$')
            ->setCreatedAt();

        $tzId = Uuid::uuid4();
        $timezone = new Timezone($tzId);
        $timezone->setCode('America/Texas')->setTitle('America/Texas')->setUtc('-08:00')->setCreatedAt();

        $countryId = Uuid::uuid4();
        $country = new Country($countryId);
        $country
            ->addTimezone($timezone)
            ->setTitle('United States')
            ->setNumericCode('400')
            ->setIso3('USA')
            ->setIso2($this->countryIso2)
            ->setFlag('flag')
            ->setSubRegion($subRegion)
            ->setCurrency($currency)
            ->setTld('.com')
            ->setPhoneCode('1')
            ->setLatitude(10)
            ->setLongitude(10)
            ->setCreatedAt();

        $state = new State($this->id);
        $state
            ->setLatitude($this->latitude)
            ->setLongitude($this->longitude)
            ->setAltitude($this->altitude)
            ->setTitle($this->title)
            ->setType($this->type)
            ->setCode('TEST')
            ->setCountry($country);

        $this->stateRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($state);

        $this->stateFactory->expects($this->once())->method('setTitle')->with($this->title)->willReturn($this->stateFactory);
        $this->stateFactory->expects($this->once())->method('setType')->with($this->type)->willReturn($this->stateFactory);
        $this->stateFactory->expects($this->once())->method('setLatitude')->with($this->latitude)->willReturn($this->stateFactory);
        $this->stateFactory->expects($this->once())->method('setLongitude')->with($this->longitude)->willReturn($this->stateFactory);
        $this->stateFactory->expects($this->once())->method('setAltitude')->with($this->altitude)->willReturn($this->stateFactory);

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $this->stateFactory->expects($this->once())->method('setCountry')->with($country)->willReturn($this->stateFactory);

        $action = new UpdateStateAction($this->countryRepository, $this->stateRepository, $this->stateFactory);
        $actual = $action->run($this->request);

        $this->assertEquals($this->id, $actual->state->id);
    }
}