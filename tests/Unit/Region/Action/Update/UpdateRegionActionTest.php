<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Action\Update;

use App\Region\Action\Update\UpdateRegionAction;
use App\Region\Action\Update\UpdateRegionActionRequest;
use App\Region\Entity\Region;
use App\Region\Exception\RegionNotFoundException;
use App\Region\Repository\RegionRepositoryInterface;
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
        $req->setTitle($updateTitle);

        $this->regionRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($region);

        $this->regionRepository
            ->expects($this->once())
            ->method('save')
            ->with($region, true);

        $action = new UpdateRegionAction($this->regionRepository);

        try {
            $actual = $action->run($req, $id);
        } catch (RegionNotFoundException $e) {
            $this->fail('Must not throw an error: ' . $e->getMessage());
        }

        $this->assertEquals($updateTitle, $actual->regionResponse->title);
        $this->assertEquals($id, $actual->regionResponse->id);
    }

    public function testShouldThrowNotFoundExceptionIfRegionNotFound(): void
    {
        $id = Uuid::uuid7();
        $req = new UpdateRegionActionRequest();

        $this->regionRepository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new UpdateRegionAction($this->regionRepository);

        $this->expectException(RegionNotFoundException::class);
        $action->run($req, $id);
    }
}
