<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Delete;

use App\Nationality\Action\Delete\DeleteNationalityAction;
use App\Nationality\Action\Delete\DeleteNationalityActionRequest;
use App\Nationality\Entity\Nationality;
use App\Nationality\Repository\NationalityRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteNationalityActionTest extends TestCase
{
    private NationalityRepositoryInterface&MockObject $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(NationalityRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnResponseOnSuccess(): void
    {
        $id = Uuid::uuid7();
        $title = 'American';

        $nationality = new Nationality($id);
        $nationality->setTitle($title);

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($nationality);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($nationality, true);

        $action = new DeleteNationalityAction($this->repository);
        $req = new DeleteNationalityActionRequest($id->toString());

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

        $action = new DeleteNationalityAction($this->repository);
        $req = new DeleteNationalityActionRequest($id->toString());

        $action->run($req);
    }
}
