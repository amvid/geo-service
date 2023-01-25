<?php

declare(strict_types=1);

namespace App\Tests\Unit\SubRegion;

use App\Region\Entity\Region;
use App\SubRegion\Entity\SubRegion;
use App\Tests\Unit\Region\RegionDummy;
use Ramsey\Uuid\Uuid;

class SubRegionDummy
{
    public const ID = '1c26098d-cd63-47f5-9dd1-59a299b8288b';
    public const TITLE = 'Northern America';

    public static function get(?Region $region = null): SubRegion
    {
        if (!$region) {
            $region = RegionDummy::get();
        }

        $subRegionId = Uuid::fromString(self::ID);
        $subRegion = new SubRegion($subRegionId);
        $subRegion->setTitle(self::TITLE)->setRegion($region)->setCreatedAt();
        return $subRegion;
    }
}
