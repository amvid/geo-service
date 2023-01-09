<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Update;

use App\Timezone\Action\Update\UpdateTimezoneActionResponse;
use App\Timezone\Entity\Timezone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateTimezoneActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $tz = new Timezone($id);
        $tz
            ->setTitle($title)
            ->setCode($code)
            ->setUtc($utc)
            ->setCreatedAt();

        $actual = new UpdateTimezoneActionResponse($tz);

        $this->assertEquals($id, $actual->timezoneResponse->id);
        $this->assertEquals($title, $actual->timezoneResponse->title);
        $this->assertEquals($code, $actual->timezoneResponse->code);
        $this->assertEquals($utc, $actual->timezoneResponse->utc);
    }
}