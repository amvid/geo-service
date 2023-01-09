<?php

declare(strict_types=1);

namespace App\Tests\Unit\City\Action\Delete;

use App\City\Action\Delete\DeleteCityAction;
use App\City\Action\Delete\DeleteCityActionRequest;
use App\City\Repository\CityRepositoryInterface;
use App\Tests\Unit\City\CityDummy;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DeleteCityActionTest extends TestCase
{
    private CityRepositoryInterface $cityRepository;

    private UuidInterface $id;

    protected function setUp(): void
    {
        $this->cityRepository = $this->getMockBuilder(CityRepositoryInterface::class)->getMock();
        $this->id = Uuid::fromString(CityDummy::ID);
    }

    public function testShouldReturnDeleteCityActionResponseIfCityNotFound(): void
    {
        $this->cityRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(null);

        $action = new DeleteCityAction($this->cityRepository);
        $action->run(new DeleteCityActionRequest(CityDummy::ID));
    }

    public function testShouldReturnDeleteCityActionResponseOnValidDeletion(): void
    {
        $this->cityRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(CityDummy::get());

        $action = new DeleteCityAction($this->cityRepository);
        $action->run(new DeleteCityActionRequest(CityDummy::ID));
    }
}