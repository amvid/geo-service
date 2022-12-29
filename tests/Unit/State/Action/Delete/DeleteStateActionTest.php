<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Action\Delete;

use App\State\Action\Delete\DeleteStateAction;
use App\State\Action\Delete\DeleteStateActionRequest;
use App\State\Entity\State;
use App\State\Repository\StateRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteStateActionTest extends TestCase
{
    private StateRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(StateRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnResponseOnSuccess(): void
    {
        $id = Uuid::uuid4();

        $state = new State($id);

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($state);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($state, true);

        $action = new DeleteStateAction($this->repository);
        $req = new DeleteStateActionRequest($id->toString());

        $action->run($req);
    }

    public function testShouldReturnResponseIfResourceNotFound(): void
    {
        $id = Uuid::uuid4();

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);

        $action = new DeleteStateAction($this->repository);
        $req = new DeleteStateActionRequest($id->toString());

        $action->run($req);
    }

}