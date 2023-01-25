<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Create;

use App\Timezone\Action\Create\CreateTimezoneActionResponse;
use App\Timezone\Entity\Timezone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateTimezoneActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $tz = new Timezone($id);
        $tz->setTitle($title);
        $tz->setCode($code);
        $tz->setUtc($utc);
        $tz->setCreatedAt();

        $actual = new CreateTimezoneActionResponse($tz);

        $this->assertEquals($id, $actual->timezoneResponse->id);
        $this->assertEquals($title, $actual->timezoneResponse->title);
        $this->assertEquals($code, $actual->timezoneResponse->code);
        $this->assertEquals($utc, $actual->timezoneResponse->utc);
    }
}
