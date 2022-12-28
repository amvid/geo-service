<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\SubRegion\Get;

use App\Action\SubRegion\Get\GetSubRegionsAction;
use App\Action\SubRegion\Get\GetSubRegionsActionRequest;
use App\Entity\SubRegion;
use App\Region\Entity\Region;
use App\Repository\SubRegionRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetSubRegionsActionTest extends TestCase
{
    private SubRegionRepositoryInterface $repository;
    private SubRegion $easternEurope;
    private SubRegion $northernEurope;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(SubRegionRepositoryInterface::class)->getMock();

        $regionId = Uuid::uuid4();
        $regionTitle = 'Europe';
        $region = new Region($regionId);
        $region->setTitle($regionTitle);
        $region->setCreatedAt();

        $id1 = Uuid::uuid4();
        $id2 = Uuid::uuid4();

        $this->easternEurope = new SubRegion($id1);
        $this->easternEurope->setTitle('Eastern Europe');
        $this->easternEurope->setRegion($region);
        $this->easternEurope->setCreatedAt();

        $this->northernEurope = new SubRegion($id2);
        $this->northernEurope->setTitle('Northern Europe');
        $this->northernEurope->setRegion($region);
        $this->northernEurope->setCreatedAt();
    }

    public function testShouldReturnResponseArrayOfSubRegions(): void
    {
        $limit = 10;
        $offset = 0;

        $subRegions = [$this->easternEurope, $this->northernEurope];

        $this->repository
            ->expects($this->once())
            ->method('list')
            ->with($offset, $limit)
            ->willReturn($subRegions);

        $req = new GetSubRegionsActionRequest();
        $req->limit = $limit;
        $req->offset = $offset;

        $action = new GetSubRegionsAction($this->repository);
        $actual = $action->run($req);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($this->easternEurope->getId(), $actual->response[0]->id);
        $this->assertEquals($this->northernEurope->getId(), $actual->response[1]->id);
        $this->assertEquals($this->northernEurope->getRegion()->getId(), $actual->response[1]->region->id);
        $this->assertEquals($this->northernEurope->getRegion()->getId(), $actual->response[1]->region->id);
    }

}