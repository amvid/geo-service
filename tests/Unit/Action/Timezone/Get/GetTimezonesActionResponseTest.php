<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Timezone\Get;

use App\Action\Timezone\Get\GetTimezonesActionResponse;
use App\Entity\Timezone;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetTimezonesActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id1 = Uuid::uuid4();
        $id2 = Uuid::uuid4();

        $riga = new Timezone($id1);
        $oslo = new Timezone($id2);

        $actual = new GetTimezonesActionResponse([$riga, $oslo]);

        $this->assertCount(2, $actual->timezones);
        $this->assertEquals($riga, $actual->timezones[0]);
        $this->assertEquals($oslo, $actual->timezones[1]);
    }
}