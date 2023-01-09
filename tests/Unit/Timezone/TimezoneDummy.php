<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone;

use App\Timezone\Entity\Timezone;
use Ramsey\Uuid\Uuid;

class TimezoneDummy
{
    public const ID = '0b24a3a2-969d-4346-a611-c76bcdce9067';
    public const CODE = 'America/Nome';
    public const TITLE = 'Alaska Standard Time America/Nome (AKST)';
    public const UTC = '+02:00';

    public static function get(): Timezone
    {
        $timezoneId = Uuid::fromString(self::ID);
        $timezone = new Timezone($timezoneId);
        $timezone->setCode(self::CODE)->setTitle(self::TITLE)->setUtc(self::UTC)->setCreatedAt();
        return $timezone;
    }
}