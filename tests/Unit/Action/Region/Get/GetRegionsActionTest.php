<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Get;

use App\Action\Region\Get\GetRegionsAction;
use App\Action\Region\Get\GetRegionsActionRequest;
use App\Entity\Region;
use App\Repository\RegionRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetRegionsActionTest extends TestCase
{
    private RegionRepositoryInterface $repository;
    private Region $asia;
    private Region $europe;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(RegionRepositoryInterface::class)->getMock();

        $id1 = Uuid::uuid7();
        $id2 = Uuid::uuid7();

        $this->europe = new Region($id1);
        $this->europe->setTitle('Europe');
        $this->europe->setCreatedAt();

        $this->asia = new Region($id2);
        $this->asia->setTitle('Asia');
        $this->asia->setCreatedAt();
    }

    public function testShouldReturnResponseArrayOfRegions(): void
    {
        $limit = 10;
        $offset = 0;

        $regions = [$this->europe, $this->asia];

        $this->repository
            ->expects($this->once())
            ->method('list')
            ->with($offset, $limit)
            ->willReturn($regions);

        $req = new GetRegionsActionRequest();
        $req->limit = $limit;
        $req->offset = $offset;

        $action = new GetRegionsAction($this->repository);
        $actual = $action->run($req);

        $this->assertCount(2, $actual->regions);
        $this->assertEquals($this->europe, $actual->regions[0]);
        $this->assertEquals($this->asia, $actual->regions[1]);
    }

}