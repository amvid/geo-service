<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\SubRegion\Get;

use App\Action\SubRegion\Get\GetSubRegionsActionResponse;
use App\Entity\SubRegion;
use App\Region\Entity\Region;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetSubRegionsActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $regionId = Uuid::uuid4();
        $regionTitle = 'Europe';
        $region = new Region($regionId);
        $region->setTitle($regionTitle);
        $region->setCreatedAt();

        $id1 = Uuid::uuid4();
        $id2 = Uuid::uuid4();

        $easternEurope = new SubRegion($id1);
        $easternEurope->setRegion($region)->setTitle('Eastern Europe')->setCreatedAt();
        $northernEurope = new SubRegion($id2);
        $northernEurope->setRegion($region)->setTitle('Northern Europe')->setCreatedAt();

        $actual = new GetSubRegionsActionResponse([$easternEurope, $northernEurope]);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($easternEurope->getId(), $actual->response[0]->id);
        $this->assertEquals($northernEurope->getId(), $actual->response[1]->id);
        $this->assertEquals($northernEurope->getRegion()->getId(), $actual->response[1]->region->id);
        $this->assertEquals($northernEurope->getRegion()->getId(), $actual->response[1]->region->id);
    }
}