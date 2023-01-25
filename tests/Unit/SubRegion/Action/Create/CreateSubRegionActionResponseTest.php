<?php

declare(strict_types=1);

namespace App\Tests\Unit\SubRegion\Action\Create;

use App\Region\Entity\Region;
use App\SubRegion\Action\Create\CreateSubRegionActionResponse;
use App\SubRegion\Entity\SubRegion;
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
        $this->assertEquals($regionTitle, $actual->subRegionResponse->region->title);
        $this->assertEquals($regionId, $actual->subRegionResponse->region->id);
    }
}
