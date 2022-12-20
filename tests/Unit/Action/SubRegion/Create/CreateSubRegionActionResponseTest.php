<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\SubRegion\Create;

use App\Action\SubRegion\Create\CreateSubRegionActionResponse;
use App\Entity\Region;
use App\Entity\SubRegion;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateSubRegionActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $regionId = Uuid::uuid4();
        $regionTitle = 'Europe';

        $region = new Region($regionId);
        $region->setTitle($regionTitle);
        $region->setCreatedAt();

        $id = Uuid::uuid4();
        $title = 'Eastern Europe';

        $subRegion = new SubRegion($id);
        $subRegion->setTitle($title);
        $subRegion->setRegion($region);
        $subRegion->setCreatedAt();

        $actual = new CreateSubRegionActionResponse($subRegion);

        $this->assertEquals($id, $actual->subRegionResponse->id);
        $this->assertEquals($title, $actual->subRegionResponse->title);
        $this->assertEquals($subRegion->getCreatedAt(), $actual->subRegionResponse->createdAt);
        $this->assertEquals($subRegion->getUpdatedAt(), $actual->subRegionResponse->updatedAt);
        $this->assertEquals($regionTitle, $actual->subRegionResponse->region->title);
        $this->assertEquals($regionId, $actual->subRegionResponse->region->id);
        $this->assertEquals($region->getCreatedAt(), $actual->subRegionResponse->region->createdAt);
        $this->assertEquals($region->getUpdatedAt(), $actual->subRegionResponse->region->updatedAt);
    }
}