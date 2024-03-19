<?php

declare(strict_types=1);

namespace App\Airport\Action\Query;

use App\Airport\Repository\AirportRepositoryInterface;

readonly class QueryAirportsAction implements QueryAirportsActionInterface
{
    public function __construct(
        private AirportRepositoryInterface $airportRepository,
    ) {
    }

    /**
     * @throws TimezoneNotFoundException
     * @throws CityNotFoundException
     */
    public function run(QueryAirportsActionRequest $request): QueryAirportsActionResponse
    {
        return new QueryAirportsActionResponse(
            $this->airportRepository->query(
                $request->offset,
                $request->limit,
                $request->query,
            )
        );
    }
}
