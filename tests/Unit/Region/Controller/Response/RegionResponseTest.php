<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Controller\Response;

use App\Region\Controller\Response\RegionResponse;
use App\Tests\Unit\Region\RegionDummy;
use PHPUnit\Framework\TestCase;

class RegionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $region = RegionDummy::get();
        $actual = new RegionResponse($region);

        $this->assertEquals($region->getId(), $actual->id);
        $this->assertEquals($region->getTitle(), $actual->title);
    }
}
