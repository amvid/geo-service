<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Region;
use PHPUnit\Framework\TestCase;

class RegionTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $title = 'Europe';
        $region = new Region();
        $region->setTitle($title);

        self::assertEquals($title, $region->getTitle());
    }
}