<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\SubRegion;
use App\Region\Entity\Region;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SubRegionTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $title = 'Europe';
        $region = new Region($id);
        $region->setTitle($title);
        $region->setCreatedAt();

        $id2 = Uuid::uuid4();
        $title2 = 'Eastern Europe';
        $subRegion = new SubRegion($id2);
        $subRegion->setTitle($title2);
        $subRegion->setRegion($region);
        $subRegion->setCreatedAt();

        $this->assertEquals($title2, $subRegion->getTitle());
        $this->assertEquals($id2, $subRegion->getId());
        $this->assertEquals($region, $subRegion->getRegion());
        $this->assertNotNull($subRegion->getCreatedAt());
        $this->assertNotNull($subRegion->getUpdatedAt());
    }
}