<?php

declare(strict_types=1);

namespace App\Region\Fixtures;

use App\Tests\Unit\Region\RegionDummy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationalityFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $region = RegionDummy::get();
        $manager->persist($region);
        $manager->flush();
    }
}
