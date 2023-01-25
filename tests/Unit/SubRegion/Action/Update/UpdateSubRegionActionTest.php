<?php

declare(strict_types=1);

namespace App\Tests\Unit\SubRegion\Action\Update;

use App\Region\Exception\RegionNotFoundException;
use App\Region\Repository\RegionRepositoryInterface;
use App\SubRegion\Action\Update\UpdateSubRegionAction;
use App\SubRegion\Action\Update\UpdateSubRegionActionRequest;
use App\SubRegion\Entity\SubRegion;
use App\SubRegion\Exception\SubRegionNotFoundException;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use App\Tests\Unit\Region\RegionDummy;
use App\Tests\Unit\SubRegion\SubRegionDummy;
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

    public function testShouldUpdateSubRegionAndReturnResponse(): void
    {
        $region = RegionDummy::get();

        $updateTitle = 'Northern Europe';
        $title = 'Eastern Europe';
        $id = Uuid::uuid4();

        $subRegion = new SubRegion($id);
        $subRegion->setTitle($title)->setCreatedAt();

        $req = new UpdateSubRegionActionRequest();
        $req->setId($id->toString());
        $req->title = $updateTitle;
        $req->regionTitle = $region->getTitle();

        $this->regionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($region->getTitle())
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
        } catch (SubRegionNotFoundException | RegionNotFoundException $e) {
            $this->fail('Must not throw an error: ' . $e->getMessage());
        }

        $this->assertEquals($updateTitle, $actual->subRegionResponse->title);
        $this->assertEquals($id, $actual->subRegionResponse->id);
    }

    public function testShouldThrowNotFoundExceptionIfRegionNotFound(): void
    {
        $id = Uuid::uuid4();
        $regionTitle = 'Some title';
        $req = new UpdateSubRegionActionRequest();
        $req->setId($id->toString());
        $req->regionTitle = $regionTitle;

        $this->subRegionRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(SubRegionDummy::get());

        $this->regionRepository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($regionTitle)
            ->willReturn(null);

        $action = new UpdateSubRegionAction($this->subRegionRepository, $this->regionRepository);

        $this->expectException(RegionNotFoundException::class);
        $action->run($req);
    }
}
