<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Update;

use App\Action\Region\Update\UpdateRegionAction;
use App\Action\Region\Update\UpdateRegionActionRequest;
use App\Entity\Region;
use App\Exception\RegionNotFoundException;
use App\Repository\RegionRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateRegionActionTest extends TestCase
{
    private RegionRepositoryInterface $regionRepository;

    protected function setUp(): void
    {
        $this->regionRepository = $this->getMockBuilder(RegionRepositoryInterface::class)->getMock();
    }

    public function testShouldUpdateRegionAndReturnResponse(): void
    {
        $title = 'Europe';
        $updateTitle = 'Asia';
        $id = Uuid::uuid7();

        $region = new Region($id);
        $region->setTitle($title)->setCreatedAt();

        $req = new UpdateRegionActionRequest();
        $req->setTitle($updateTitle)->setId($id->toString());

        $this->regionRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($region);

        $this->regionRepository
            ->expects($this->once())
            ->method('save')
            ->with($region);

        $action = new UpdateRegionAction($this->regionRepository);

        try {
            $actual = $action->run($req);
        } catch (RegionNotFoundException $e) {
            $this->fail('Must not throw an error: ' . $e->getMessage());
        }

        $this->assertEquals($updateTitle, $actual->title);
        $this->assertEquals($id, $actual->id);
    }

    public function testShouldThrowNotFoundExceptionIfRegionNotFound(): void
    {
        $id = Uuid::uuid7();
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