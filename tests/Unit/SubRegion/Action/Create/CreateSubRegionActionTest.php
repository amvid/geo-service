<?php

declare(strict_types=1);

namespace App\Tests\Unit\SubRegion\Action\Create;

use App\Region\Exception\RegionNotFoundException;
use App\Region\Repository\RegionRepositoryInterface;
use App\SubRegion\Action\Create\CreateSubRegionAction;
use App\SubRegion\Action\Create\CreateSubRegionActionRequest;
use App\SubRegion\Action\Create\CreateSubRegionActionResponse;
use App\SubRegion\Entity\SubRegion;
use App\SubRegion\Exception\SubRegionAlreadyExistsException;
use App\SubRegion\Factory\SubRegionFactoryInterface;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use App\Tests\Unit\Region\RegionDummy;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateSubRegionActionTest extends TestCase
{
    private readonly SubRegionFactoryInterface $factory;
    private readonly SubRegionRepositoryInterface $subRegionRepository;
    private readonly RegionRepositoryInterface $regionRepository;

    protected function setUp(): void
    {
        $this->factory = $this->getMockBuilder(SubRegionFactoryInterface::class)->getMock();
        $this->regionRepository = $this->getMockBuilder(RegionRepositoryInterface::class)->getMock();
        $this->subRegionRepository = $this->getMockBuilder(SubRegionRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnAValidResponseOnSuccess(): void
    {
        $region = RegionDummy::get();

        $subRegionId = Uuid::uuid4();
        $subRegionTitle = 'Eastern Europe';
        $subRegion = new SubRegion($subRegionId);
        $subRegion->setRegion($region);
        $subRegion->setTitle($subRegionTitle);
        $subRegion->setCreatedAt();

        $regionId = Uuid::fromString(RegionDummy::ID);
        $request = new CreateSubRegionActionRequest($subRegionTitle, RegionDummy::ID);
        $this->assertEquals($subRegionTitle, $request->title);

        $expectedResponse = new CreateSubRegionActionResponse($subRegion);

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($subRegionTitle)
            ->willReturn(null);

        $this->regionRepository
            ->expects($this->once())
            ->method('findById')
            ->with($regionId)
            ->willReturn($region);

        $this->factory->expects($this->once())->method('setTitle')->with($subRegionTitle)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('setRegion')->with($region)->willReturn($this->factory);
        $this->factory->expects($this->once())->method('create')->willReturn($subRegion);
        $this->subRegionRepository->expects($this->once())->method('save')->with($subRegion, true);

        $action = new CreateSubRegionAction($this->regionRepository, $this->subRegionRepository, $this->factory);

        try {
            $actual = $action->run($request);
        } catch (RegionNotFoundException|SubRegionAlreadyExistsException $e) {
            $this->fail('Must not thrown an exception: ' . $e->getMessage());
        }

        $this->assertEquals($expectedResponse->subRegionResponse->id, $actual->subRegionResponse->id);
        $this->assertEquals($expectedResponse->subRegionResponse->title, $actual->subRegionResponse->title);
        $this->assertEquals($expectedResponse->subRegionResponse->region->id, $actual->subRegionResponse->region->id);
        $this->assertEquals($expectedResponse->subRegionResponse->region->title, $actual->subRegionResponse->region->title);
    }

    public function testShouldThrowAnErrorIfTitleHasBeenAlreadyTaken(): void
    {
        $title = 'Eastern Europe';
        $this->subRegionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($title)
            ->willReturn(new SubRegion());

        $action = new CreateSubRegionAction($this->regionRepository, $this->subRegionRepository, $this->factory);
        $request = new CreateSubRegionActionRequest($title, Uuid::uuid4()->toString());

        $this->expectException(SubRegionAlreadyExistsException::class);
        $action->run($request);
    }

}