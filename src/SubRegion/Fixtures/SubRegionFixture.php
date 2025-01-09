<?php

declare(strict_types=1);

namespace App\SubRegion\Fixtures;

use App\Region\Entity\Region;
use App\Region\Fixtures\RegionFixture;
use App\Tests\Unit\SubRegion\SubRegionDummy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubRegionFixture extends Fixture implements DependentFixtureInterface
{
    public const SUBREGION_REFERENCE = 'subregion';

    public function load(ObjectManager $manager): void
    {
        /** @var Region $region */
        $region = $this->getReference(RegionFixture::REGION_REFERENCE, Region::class);
        $subRegion = SubRegionDummy::get($region);
        $manager->persist($subRegion);
        $manager->flush();

        $this->addReference(self::SUBREGION_REFERENCE, $subRegion);
    }

    public function getDependencies(): array
    {
        return [
            RegionFixture::class,
        ];
    }
}
