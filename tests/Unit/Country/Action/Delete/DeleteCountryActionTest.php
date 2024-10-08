<?php

declare(strict_types=1);

namespace App\Tests\Unit\Country\Action\Delete;

use App\Country\Action\Delete\DeleteCountryAction;
use App\Country\Action\Delete\DeleteCountryActionRequest;
use App\Country\Entity\Country;
use App\Country\Repository\CountryRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCountryActionTest extends TestCase
{
    private CountryRepositoryInterface&MockObject $repository;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder(CountryRepositoryInterface::class)->getMock();
    }

    public function testShouldReturnResponseOnSuccess(): void
    {
        $id = Uuid::uuid4();

        $country = new Country($id);

        $this->repository
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($country);

        $this->repository
            ->expects($this->once())
            ->method('remove')
            ->with($country, true);

        $action = new DeleteCountryAction($this->repository);
        $req = new DeleteCountryActionRequest($id->toString());

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

        $action = new DeleteCountryAction($this->repository);
        $req = new DeleteCountryActionRequest($id->toString());

        $action->run($req);
    }
}
