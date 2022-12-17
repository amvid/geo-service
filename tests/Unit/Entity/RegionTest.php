<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Region;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class RegionTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::v1();
        $title = 'Europe';
        $region = new Region($id);
        $region->setTitle($title);
        $region->setCreatedAt();

        $this->assertEquals($title, $region->getTitle());
        $this->assertEquals($id, $region->getId());
        $this->assertNotNull($region->getCreatedAt());
        $this->assertNotNull($region->getUpdatedAt());
    }
}