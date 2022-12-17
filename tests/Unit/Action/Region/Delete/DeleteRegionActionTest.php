<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Delete;

use App\Action\Region\Delete\DeleteRegionAction;
use App\Action\Region\Delete\DeleteRegionActionRequest;
use App\Entity\Region;
use App\Repository\RegionRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DeleteRegionActionTest extends TestCase
{
    private RegionRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(RegionRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnResponseOnSuccess(): void
    {
        $id = Uuid::v1();
        $title = 'Europe';

        $region = new Region($id);
        $region->setTitle($title);

        $this->repository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($title)
            ->willReturn($region);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($region);

        $action = new DeleteRegionAction($this->repository);
        $req = new DeleteRegionActionRequest($title);

        $action->run($req);
    }

    public function testShouldReturnResponseIfResourceNotFound(): void
    {
        $title = 'Europe';

        $this->repository
            ->expects($this->once())
            ->method('findByTitle')
            ->with($title)
            ->willReturn(null);

        $action = new DeleteRegionAction($this->repository);
        $req = new DeleteRegionActionRequest($title);

        $action->run($req);
    }

}