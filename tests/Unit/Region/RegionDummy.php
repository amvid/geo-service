<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region;

use App\Region\Entity\Region;
use Ramsey\Uuid\Uuid;

class RegionDummy
{
    public const ID = '051da3fc-b555-41f7-8cd5-dc0bf1ff3471';
    public const TITLE = 'America';

    public static function get(): Region
    {
        $regionId = Uuid::fromString(self::ID);
        $region = new Region($regionId);
        $region->setTitle(self::TITLE)->setCreatedAt();
        return $region;
    }
}