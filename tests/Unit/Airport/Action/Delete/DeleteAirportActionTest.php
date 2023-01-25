<?php

declare(strict_types=1);

namespace App\Tests\Unit\Airport\Action\Delete;

use App\Airport\Action\Delete\DeleteAirportAction;
use App\Airport\Action\Delete\DeleteAirportActionRequest;
use App\Airport\Repository\AirportRepositoryInterface;
use App\Tests\Unit\Airport\AirportDummy;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class DeleteAirportActionTest extends TestCase
{
    private AirportRepositoryInterface $airportRepository;

    private UuidInterface $id;

    protected function setUp(): void
    {
        $this->airportRepository = $this->getMockBuilder(AirportRepositoryInterface::class)->getMock();
        $this->id = Uuid::fromString(AirportDummy::ID);
    }

    public function testShouldReturnDeleteAirportActionResponseIfCityNotFound(): void
    {
        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn(null);

        $action = new DeleteAirportAction($this->airportRepository);
        $action->run(new DeleteAirportActionRequest(AirportDummy::ID));
    }

    public function testShouldReturnDeleteAirportActionResponseOnValidDeletion(): void
    {
        $airport = AirportDummy::get();
        $this->airportRepository
            ->expects($this->once())
            ->method('findById')
            ->with($this->id)
            ->willReturn($airport);

        $this->airportRepository
            ->expects($this->once())
            ->method('remove')
            ->with($airport, true);

        $action = new DeleteAirportAction($this->airportRepository);
        $action->run(new DeleteAirportActionRequest($airport->getId()->toString()));
    }
}
