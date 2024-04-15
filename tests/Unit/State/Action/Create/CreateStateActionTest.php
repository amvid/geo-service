<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Action\Create;

use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Action\Create\CreateStateAction;
use App\State\Action\Create\CreateStateActionRequest;
use App\State\Entity\State;
use App\State\Exception\StateAlreadyExistsException;
use App\State\Factory\StateFactoryInterface;
use App\State\Repository\StateRepositoryInterface;
use App\Tests\Unit\Country\CountryDummy;
use App\Tests\Unit\State\StateDummy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateStateActionTest extends TestCase
{
    private CountryRepositoryInterface&MockObject $countryRepository;
    private StateRepositoryInterface&MockObject $stateRepository;
    private StateFactoryInterface&MockObject $factory;

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
            ->method('findByTitle')
            ->with($this->title)
            ->willReturn(new State());

        $action = new CreateStateAction($this->countryRepository, $this->stateRepository, $this->factory);
        $this->expectException(StateAlreadyExistsException::class);
        $action->run($this->request);
    }

    public function testShouldThrowCountryNotFoundException(): void
    {
        $this->stateRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($this->title)
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
            ->method('findByTitle')
            ->with($this->title)
            ->willReturn(null);

        $country = CountryDummy::get();

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $state = StateDummy::get($country);

        $this->factory->expects($this->once())->method('setCountry')->with($country)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setCode')->with($this->code)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setTitle')->with($this->title)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setType')->with($this->type)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setLatitude')->with($this->latitude)->willReturn($this->factory);
        $this->factory
            ->expects($this->once())->method('setLongitude')->with($this->longitude)->willReturn($this->factory);
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
    }
}
