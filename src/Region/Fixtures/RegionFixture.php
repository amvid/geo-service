<?php

declare(strict_types=1);

namespace App\Region\Fixtures;

use App\Tests\Unit\Region\RegionDummy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegionFixture extends Fixture
{
    public const REGION_REFERENCE = 'region';

    public function load(ObjectManager $manager): void
    {
        $region = RegionDummy::get();
        $manager->persist($region);
        $manager->flush();

        $this->addReference(self::REGION_REFERENCE, $region);
    }
}
