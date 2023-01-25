<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Entity;

use App\Timezone\Entity\Timezone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TimezoneTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $tz = (new Timezone($id))
            ->setCode($code)
            ->setTitle($title)
            ->setUtc($utc);
        $tz->setCreatedAt();

        $this->assertEquals($id, $tz->getId());
        $this->assertEquals($title, $tz->getTitle());
        $this->assertEquals($code, $tz->getCode());
        $this->assertEquals($utc, $tz->getUtc());
        $this->assertNotNull($tz->getCreatedAt());
        $this->assertNotNull($tz->getUpdatedAt());
    }
}
