<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Delete;

use App\Timezone\Action\Delete\DeleteTimezoneAction;
use App\Timezone\Action\Delete\DeleteTimezoneActionRequest;
use App\Timezone\Entity\Timezone;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteTimezoneActionTest extends TestCase
{
    private TimezoneRepositoryInterface&MockObject $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(TimezoneRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnResponseOnSuccess(): void
    {
        $id = Uuid::uuid7();
        $title = 'Europe';

        $tz = new Timezone($id);
        $tz->setTitle($title);

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($tz);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($tz, true);

        $action = new DeleteTimezoneAction($this->repository);
        $req = new DeleteTimezoneActionRequest($id->toString());

        $action->run($req);
    }

    public function testShouldReturnResponseIfResourceNotFound(): void
    {
        $id = Uuid::uuid7();

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new DeleteTimezoneAction($this->repository);
        $req = new DeleteTimezoneActionRequest($id->toString());

        $action->run($req);
    }
}
