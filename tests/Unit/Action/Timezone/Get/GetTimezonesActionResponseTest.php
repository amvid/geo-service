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
        $riga->setTitle('Europe/Riga (GMT+02:00')->setCode('Europe/Riga')->setUtc('+02:00')->setCreatedAt();
        $oslo = new Timezone($id2);
        $oslo->setTitle('Europe/Oslo (GMT+01:00')->setCode('Europe/Oslo')->setUtc('+01:00')->setCreatedAt();

        $actual = new GetTimezonesActionResponse([$riga, $oslo]);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($riga->getId(), $actual->response[0]->id);
        $this->assertEquals($oslo->getId(), $actual->response[1]->id);
    }
}