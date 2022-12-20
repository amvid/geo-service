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

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($subRegion->getCreatedAt(), $actual->createdAt);
        $this->assertEquals($subRegion->getUpdatedAt(), $actual->updatedAt);
        $this->assertEquals($regionTitle, $actual->region->title);
        $this->assertEquals($regionId, $actual->region->id);
        $this->assertEquals($region->getCreatedAt(), $actual->region->createdAt);
        $this->assertEquals($region->getUpdatedAt(), $actual->region->updatedAt);
    }
}