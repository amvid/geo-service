<?php

declare(strict_types=1);

namespace App\Nationality\Fixtures;

use App\Tests\Unit\Nationality\NationalityDummy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationalityFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nationality = NationalityDummy::get();
        $manager->persist($nationality);
        $manager->flush();
    }
}
