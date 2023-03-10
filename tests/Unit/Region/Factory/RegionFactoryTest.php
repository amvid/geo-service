<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Factory;

use App\Region\Factory\RegionFactory;
use App\Region\Factory\RegionFactoryInterface;
use PHPUnit\Framework\TestCase;

class RegionFactoryTest extends TestCase
{
    private RegionFactoryInterface $regionFactory;

    protected function setUp(): void
    {
        $this->regionFactory = new RegionFactory();
    }

    public function testShouldReturnANewRegion(): void
    {
        $title = 'Europe';

        $actual = $this->regionFactory
            ->setTitle($title)
            ->create();

        $this->assertEquals($title, $actual->getTitle());
    }
}
