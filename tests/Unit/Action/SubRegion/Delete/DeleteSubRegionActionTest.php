<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\SubRegion\Delete;

use App\Action\Region\Delete\DeleteRegionAction;
use App\Action\Region\Delete\DeleteRegionActionRequest;
use App\Action\SubRegion\Delete\DeleteSubRegionAction;
use App\Action\SubRegion\Delete\DeleteSubRegionActionRequest;
use App\Entity\SubRegion;
use App\Repository\SubRegionRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteSubRegionActionTest extends TestCase
{
    private SubRegionRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(SubRegionRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnResponseOnSuccess(): void
    {
        $id = Uuid::uuid4();
        $title = 'Eastern Europe';

        $subRegion = new SubRegion($id);
        $subRegion->setTitle($title);

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($subRegion);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($subRegion);

        $action = new DeleteSubRegionAction($this->repository);
        $req = new DeleteSubRegionActionRequest($id->toString());

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

        $action = new DeleteSubRegionAction($this->repository);
        $req = new DeleteSubRegionActionRequest($id->toString());

        $action->run($req);
    }

}