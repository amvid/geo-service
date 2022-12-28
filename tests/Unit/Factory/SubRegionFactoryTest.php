<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Factory\SubRegionFactory;
use App\Factory\SubRegionFactoryInterface;
use App\Region\Entity\Region;
use PHPUnit\Framework\TestCase;

class SubRegionFactoryTest extends TestCase
{
    private SubRegionFactoryInterface $subRegionFactory;

    protected function setUp(): void
    {
        $this->subRegionFactory = new SubRegionFactory();
    }

    public function testShouldReturnANewSubRegion(): void
    {
        $title = 'Europe';
        $region = new Region();
        $region->setTitle($title);

        $title2 = 'Eastern Europe';

        $actual = $this->subRegionFactory
            ->setTitle($title2)
            ->setRegion($region)
            ->create();

        $this->assertEquals($title2, $actual->getTitle());
        $this->assertEquals($region, $actual->getRegion());
    }
}