<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Timezone\Create;

use App\Action\Timezone\Create\CreateTimezoneAction;
use App\Action\Timezone\Create\CreateTimezoneActionRequest;
use App\Action\Timezone\Create\CreateTimezoneActionResponse;
use App\Entity\Timezone;
use App\Exception\TimezoneAlreadyExistsException;
use App\Factory\TimezoneFactoryInterface;
use App\Repository\TimezoneRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateTimezoneActionTest extends TestCase
{
    private readonly TimezoneFactoryInterface $factory;
    private readonly TimezoneRepositoryInterface $repository;

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

        $request = new CreateTimezoneActionRequest($title, $code, $utc);
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

        $action = new CreateTimezoneAction($this->repository, $this->factory);

        try {
            $actual = $action->run($request);
        } catch (TimezoneAlreadyExistsException $e) {
            $this->fail('Must not thrown an exception: ' . $e->getMessage());
        }

        $this->assertEquals($expectedResponse->id, $actual->id);
        $this->assertEquals($expectedResponse->title, $actual->title);
        $this->assertEquals($expectedResponse->code, $actual->code);
        $this->assertEquals($expectedResponse->utc, $actual->utc);
        $this->assertEquals($expectedResponse->createdAt, $actual->createdAt);
        $this->assertEquals($expectedResponse->updatedAt, $actual->updatedAt);
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
        $request = new CreateTimezoneActionRequest($title, $code, $utc);

        $this->expectException(TimezoneAlreadyExistsException::class);
        $action->run($request);
    }

}