<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Action\Delete;

use App\Region\Action\Delete\DeleteRegionAction;
use App\Region\Action\Delete\DeleteRegionActionRequest;
use App\Region\Entity\Region;
use App\Region\Repository\RegionRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteRegionActionTest extends TestCase
{
    private RegionRepositoryInterface&MockObject $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(RegionRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnResponseOnSuccess(): void
    {
        $id = Uuid::uuid7();
        $title = 'Europe';

        $region = new Region($id);
        $region->setTitle($title);

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($region);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($region, true);

        $action = new DeleteRegionAction($this->repository);
        $req = new DeleteRegionActionRequest($id->toString());

        $action->run($req);
    }

    public function testShouldReturnResponseIfResourceNotFound(): void
    {
        $id = Uuid::uuid7();

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new DeleteRegionAction($this->repository);
        $req = new DeleteRegionActionRequest($id->toString());

        $action->run($req);
    }
}
