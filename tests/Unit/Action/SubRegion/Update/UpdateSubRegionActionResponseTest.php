<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\SubRegion\Update;

use App\Action\SubRegion\Update\UpdateSubRegionActionResponse;
use App\Entity\Region;
use App\Entity\SubRegion;
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

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($subRegion->getUpdatedAt(), $actual->updatedAt);
        $this->assertEquals($subRegion->getCreatedAt(), $actual->createdAt);
        $this->assertEquals($regionTitle, $actual->region->title);
        $this->assertEquals($regionId, $actual->region->id);
    }
}