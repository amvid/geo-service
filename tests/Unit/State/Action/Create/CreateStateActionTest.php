<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Action\Create;

use App\Country\Entity\Country;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\Currency\Entity\Currency;
use App\Region\Entity\Region;
use App\State\Action\Create\CreateStateAction;
use App\State\Action\Create\CreateStateActionRequest;
use App\State\Entity\State;
use App\State\Exception\StateAlreadyExistsException;
use App\State\Factory\StateFactoryInterface;
use App\State\Repository\StateRepositoryInterface;
use App\SubRegion\Entity\SubRegion;
use App\Timezone\Entity\Timezone;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateStateActionTest extends TestCase
{
    private CountryRepositoryInterface $countryRepository;
    private StateRepositoryInterface $stateRepository;
    private StateFactoryInterface $factory;

    private string $title = 'New Jersey';
    private string $code = 'NJ';
    private string $type = 'state';
    private string $countryIso2 = 'US';
    private float $longitude = 10.5;
    private float $latitude = 55.2;

    private CreateStateActionRequest $request;

    protected function setUp(): void
    {
        $this->countryRepository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();
        $this->stateRepository = $this->getMockBuilder(StateRepositoryInterface::class)->getMock();
        $this->factory = $this->getMockBuilder(StateFactoryInterface::class)->getMock();

        $this->request = new CreateStateActionRequest();
        $this->request->title = $this->title;
        $this->request->code = $this->code;
        $this->request->type = $this->type;
        $this->request->countryIso2 = $this->countryIso2;
        $this->request->latitude = $this->latitude;
        $this->request->longitude = $this->longitude;
    }

    public function testShouldThrowStateAlreadyExistsException(): void
    {
        $this->stateRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->code)
            ->willReturn(new State());

        $action = new CreateStateAction($this->countryRepository, $this->stateRepository, $this->factory);
        $this->expectException(StateAlreadyExistsException::class);
        $action->run($this->request);
    }

    public function testShouldThrowCountryNotFoundException(): void
    {
        $this->stateRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->code)
            ->willReturn(null);

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn(null);

        $action = new CreateStateAction($this->countryRepository, $this->stateRepository, $this->factory);

        $this->expectException(CountryNotFoundException::class);
        $this->expectExceptionMessage("Country '$this->countryIso2' not found.");

        $action->run($this->request);
    }

    public function testShouldReturnValidCreateStateActionResponse(): void
    {
        $this->stateRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($this->code)
            ->willReturn(null);

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
            ->setIso2('US')
            ->setFlag('flag')
            ->setSubRegion($subRegion)
            ->setCurrency($currency)
            ->setTld('.com')
            ->setPhoneCode('1')
            ->setLatitude(10)
            ->setLongitude(10)
            ->setCreatedAt();

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $stateId = Uuid::uuid4();
        $state = new State($stateId);
        $state
            ->setCountry($country)
            ->setCode($this->code)
            ->setType($this->type)
            ->setTitle($this->title)
            ->setLongitude($this->longitude)
            ->setLatitude($this->latitude)
            ->setAltitude(null)
            ->setCreatedAt();

        $this->factory->expects($this->once())->method('setCountry')->with($country)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setCode')->with($this->code)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setTitle')->with($this->title)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setType')->with($this->type)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setLatitude')->with($this->latitude)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setLongitude')->with($this->longitude)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setAltitude')->with(null)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('create')->willReturn($state);

        $this->stateRepository
            ->expects($this->once())
            ->method('save')
            ->with($state, true);

        $action = new CreateStateAction($this->countryRepository, $this->stateRepository, $this->factory);
        $actual = $action->run($this->request);

        $this->assertEquals($this->code, $actual->state->code);
        $this->assertEquals($this->title, $actual->state->title);
        $this->assertEquals($this->type, $actual->state->type);
        $this->assertEquals($this->latitude, $actual->state->latitude);
        $this->assertEquals($this->longitude, $actual->state->longitude);
        $this->assertEquals($countryId, $actual->state->country->id);
    }
}