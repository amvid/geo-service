<?php

declare(strict_types=1);

namespace App\Airport\Action\Delete;

use App\Airport\Repository\AirportRepositoryInterface;

readonly class DeleteAirportAction implements DeleteAirportActionInterface
{
    public function __construct(private AirportRepositoryInterface $airportRepository)
    {
    }

    public function run(DeleteAirportActionRequest $request): DeleteAirportActionResponse
    {
        $exists = $this->airportRepository->findById($request->id);
        $res = new DeleteAirportActionResponse();

        if (!$exists) {
            return $res;
        }
        $this->airportRepository->remove($exists, true);

        return $res;
    }
}