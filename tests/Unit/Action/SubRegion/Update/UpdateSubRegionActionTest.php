<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\SubRegion\Update;

use App\Action\SubRegion\Update\UpdateSubRegionAction;
use App\Action\SubRegion\Update\UpdateSubRegionActionRequest;
use App\Entity\SubRegion;
use App\Exception\SubRegionNotFoundException;
use App\Region\Action\Update\UpdateRegionAction;
use App\Region\Action\Update\UpdateRegionActionRequest;
use App\Region\Entity\Region;
use App\Region\Exception\RegionNotFoundException;
use App\Region\Repository\RegionRepositoryInterface;
use App\Repository\SubRegionRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateSubRegionActionTest extends TestCase
{
    private SubRegionRepositoryInterface $subRegionRepository;
    private RegionRepositoryInterface $regionRepository;

    protected function setUp(): void
    {
        $this->subRegionRepository = $this->getMockBuilder(SubRegionRepositoryInterface::class)->getMock();
        $this->regionRepository = $this->getMockBuilder(RegionRepositoryInterface::class)->getMock();
    }

    public function testShouldUpdateRegionAndReturnResponse(): void
    {
        $regionId = Uuid::uuid4();
        $regionTitle = 'Europe';
        $region = new Region($regionId);
        $region->setTitle($regionTitle)->setCreatedAt();

        $updateTitle = 'Northern Europe';
        $title = 'Eastern Europe';
        $id = Uuid::uuid4();

        $subRegion = new SubRegion($id);
        $subRegion->setTitle($title)->setCreatedAt();

        $req = new UpdateSubRegionActionRequest($title, $regionId->toString());
        $req->setTitle($updateTitle)->setId($id->toString());

        $this->regionRepository
            ->expects($this->once())
            ->method('findById')
            ->with($regionId)
            ->willReturn($region);

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($subRegion);

        $this->subRegionRepository
            ->expects($this->once())
            ->method('save')
            ->with($subRegion, true);

        $action = new UpdateSubRegionAction($this->subRegionRepository, $this->regionRepository);

        try {
            $actual = $action->run($req);
        } catch (SubRegionNotFoundException|RegionNotFoundException $e) {
            $this->fail('Must not throw an error: ' . $e->getMessage());
        }

        $this->assertEquals($updateTitle, $actual->subRegionResponse->title);
        $this->assertEquals($id, $actual->subRegionResponse->id);
    }

    public function testShouldThrowNotFoundExceptionIfRegionNotFound(): void
    {
        $id = Uuid::uuid4();
        $req = new UpdateRegionActionRequest();
        $req->setId($id->toString());

        $this->regionRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new UpdateRegionAction($this->regionRepository);

        $this->expectException(RegionNotFoundException::class);
        $action->run($req);
    }
}