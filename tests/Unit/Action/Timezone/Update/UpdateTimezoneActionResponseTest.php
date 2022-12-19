<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Timezone\Update;

use App\Action\Timezone\Update\UpdateTimezoneActionResponse;
use App\Entity\Timezone;
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

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($code, $actual->code);
        $this->assertEquals($utc, $actual->utc);
        $this->assertEquals($tz->getUpdatedAt(), $actual->updatedAt);
        $this->assertEquals($tz->getCreatedAt(), $actual->createdAt);
    }
}