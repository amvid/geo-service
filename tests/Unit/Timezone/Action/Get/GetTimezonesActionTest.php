<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Get;

use App\Timezone\Action\Get\GetTimezonesAction;
use App\Timezone\Action\Get\GetTimezonesActionRequest;
use App\Timezone\Entity\Timezone;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetTimezonesActionTest extends TestCase
{
    private TimezoneRepositoryInterface&MockObject $repository;
    private Timezone $riga;
    private Timezone $oslo;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();

        $id1 = Uuid::uuid4();
        $id2 = Uuid::uuid4();

        $this->riga = new Timezone($id1);
        $this->riga->setTitle('Europe/Riga (GMT+02:00)');
        $this->riga->setCode('Europe/Riga');
        $this->riga->setUtc('+02:00');
        $this->riga->setCreatedAt();

        $this->oslo = new Timezone($id2);
        $this->oslo->setTitle('Europe/Oslo (GMT+01:00)');
        $this->oslo->setCode('Europe/Oslo');
        $this->oslo->setUtc('+01:00');
        $this->oslo->setCreatedAt();
    }

    public function testShouldReturnResponseArrayOfRegions(): void
    {
        $limit = 10;
        $offset = 0;

        $timezones = [$this->riga, $this->oslo];

        $this->repository
            ->expects($this->once())
            ->method('list')
            ->with($offset, $limit)
            ->willReturn($timezones);

        $req = new GetTimezonesActionRequest();
        $req->limit = $limit;
        $req->offset = $offset;

        $action = new GetTimezonesAction($this->repository);
        $actual = $action->run($req);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($this->riga->getId(), $actual->response[0]->id);
        $this->assertEquals($this->oslo->getId(), $actual->response[1]->id);
    }
}
