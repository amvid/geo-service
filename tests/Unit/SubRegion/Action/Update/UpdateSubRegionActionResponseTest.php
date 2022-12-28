<?php

declare(strict_types=1);

namespace App\Tests\Unit\SubRegion\Action\Update;

use App\Region\Entity\Region;
use App\SubRegion\Action\Update\UpdateSubRegionActionResponse;
use App\SubRegion\Entity\SubRegion;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateSubRegionActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $regionId = Uuid::uuid4();
        $regionTitle = 'Europe';
        $region = new Region($regionId);
        $region->setTitle($regionTitle)->setCreatedAt();

        $id = Uuid::uuid4();
        $title = 'Eastern Europe';
        $subRegion = new SubRegion($id);
        $subRegion->setTitle($title)->setCreatedAt();
        $subRegion->setRegion($region);

        $actual = new UpdateSubRegionActionResponse($subRegion);

        $this->assertEquals($id, $actual->subRegionResponse->id);
        $this->assertEquals($title, $actual->subRegionResponse->title);
        $this->assertEquals($subRegion->getUpdatedAt(), $actual->subRegionResponse->updatedAt);
        $this->assertEquals($subRegion->getCreatedAt(), $actual->subRegionResponse->createdAt);
        $this->assertEquals($regionTitle, $actual->subRegionResponse->region->title);
        $this->assertEquals($regionId, $actual->subRegionResponse->region->id);
    }
}