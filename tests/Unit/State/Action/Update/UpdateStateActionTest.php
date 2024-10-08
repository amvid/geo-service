<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Action\Update;

use App\Country\Repository\CountryRepositoryInterface;
use App\State\Action\Update\UpdateStateAction;
use App\State\Action\Update\UpdateStateActionRequest;
use App\State\Entity\State;
use App\State\Exception\StateNotFoundException;
use App\State\Factory\StateFactoryInterface;
use App\State\Repository\StateRepositoryInterface;
use App\Tests\Unit\Country\CountryDummy;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UpdateStateActionTest extends TestCase
{
    private StateFactoryInterface&MockObject $stateFactory;
    private StateRepositoryInterface&MockObject $stateRepository;
    private CountryRepositoryInterface&MockObject $countryRepository;

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
        $action->run($this->request, $this->id);
    }

    public function testShouldReturnNewUpdateStateResponse(): void
    {
        $country = CountryDummy::get();

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

        $this->stateFactory
            ->expects($this->once())->method('setTitle')->with($this->title)->willReturn($this->stateFactory);
        $this->stateFactory
            ->expects($this->once())->method('setType')->with($this->type)->willReturn($this->stateFactory);
        $this->stateFactory
            ->expects($this->once())->method('setLatitude')->with($this->latitude)->willReturn($this->stateFactory);
        $this->stateFactory
            ->expects($this->once())->method('setLongitude')->with($this->longitude)->willReturn($this->stateFactory);
        $this->stateFactory
            ->expects($this->once())->method('setAltitude')->with($this->altitude)->willReturn($this->stateFactory);

        $this->countryRepository
            ->expects($this->once())
            ->method('findByIso2')
            ->with($this->countryIso2)
            ->willReturn($country);

        $this->stateFactory
            ->expects($this->once())->method('setCountry')->with($country)->willReturn($this->stateFactory);

        $action = new UpdateStateAction($this->countryRepository, $this->stateRepository, $this->stateFactory);
        $actual = $action->run($this->request, $this->id);

        $this->assertEquals($this->id, $actual->state->id);
    }
}
