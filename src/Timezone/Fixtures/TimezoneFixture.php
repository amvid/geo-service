<?php

declare(strict_types=1);

namespace App\Timezone\Fixtures;

use App\Tests\Unit\Timezone\TimezoneDummy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TimezoneFixture extends Fixture
{
    public const TIMEZONE_REFERENCE = 'timezone';

    public function load(ObjectManager $manager): void
    {
        $tz = TimezoneDummy::get();
        $manager->persist($tz);
        $manager->flush();

        $this->addReference(self::TIMEZONE_REFERENCE, $tz);
    }
}
