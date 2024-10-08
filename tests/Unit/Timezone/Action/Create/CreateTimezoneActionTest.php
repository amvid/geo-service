<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Create;

use App\Timezone\Action\Create\CreateTimezoneAction;
use App\Timezone\Action\Create\CreateTimezoneActionRequest;
use App\Timezone\Action\Create\CreateTimezoneActionResponse;
use App\Timezone\Entity\Timezone;
use App\Timezone\Exception\TimezoneAlreadyExistsException;
use App\Timezone\Factory\TimezoneFactoryInterface;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateTimezoneActionTest extends TestCase
{
    private readonly TimezoneFactoryInterface&MockObject $factory;
    private readonly TimezoneRepositoryInterface&MockObject $repository;

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(TimezoneFactoryInterface::class)->getMock();
        $this->repository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnAValidResponseOnSuccess(): void
    {
        $id = Uuid::uuid7();
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $request = new CreateTimezoneActionRequest();
        $request->code = $code;
        $request->title = $title;
        $request->utc = $utc;

        $this->assertEquals($title, $request->title);
        $this->assertEquals($code, $request->code);
        $this->assertEquals($utc, $request->utc);

        $tz = new Timezone($id);
        $tz->setTitle($title);
        $tz->setCode($code);
        $tz->setUtc($utc);
        $tz->setCreatedAt();

        $expectedResponse = new CreateTimezoneActionResponse($tz);

        $this->repository->expects($this->once())->method('findByTitle')->with($title)->willReturn(null);
        $this->factory->expects($this->once())->method('setTitle')->with($title)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setCode')->with($code)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setUtc')->with($utc)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('create')->willReturn($tz);
        $this->repository->expects($this->once())->method('save')->with($tz, true);

        $action = new CreateTimezoneAction($this->repository, $this->factory);

        try {
            $actual = $action->run($request);
        } catch (TimezoneAlreadyExistsException $e) {
            $this->fail('Must not thrown an exception: ' . $e->getMessage());
        }

        $this->assertEquals($expectedResponse->timezoneResponse->id, $actual->timezoneResponse->id);
        $this->assertEquals($expectedResponse->timezoneResponse->title, $actual->timezoneResponse->title);
        $this->assertEquals($expectedResponse->timezoneResponse->code, $actual->timezoneResponse->code);
        $this->assertEquals($expectedResponse->timezoneResponse->utc, $actual->timezoneResponse->utc);
    }

    public function testShouldThrowAnErrorIfTitleHasBeenAlreadyTaken(): void
    {
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $this->repository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($title)
            ->willReturn(new Timezone());

        $action = new CreateTimezoneAction($this->repository, $this->factory);
        $request = new CreateTimezoneActionRequest();
        $request->code = $code;
        $request->title = $title;
        $request->utc = $utc;

        $this->expectException(TimezoneAlreadyExistsException::class);
        $action->run($request);
    }
}
