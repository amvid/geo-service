<?php

declare(strict_types=1);

namespace App\Airport\Action\Get;

use App\Airport\Repository\AirportRepositoryInterface;
use App\City\Exception\CityNotFoundException;
use App\City\Repository\CityRepositoryInterface;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;

readonly class GetAirportsAction implements GetAirportsActionInterface
{
    public function __construct(
        private AirportRepositoryInterface $airportRepository,
        private CityRepositoryInterface $cityRepository,
        private TimezoneRepositoryInterface $timezoneRepository,
    ) {
    }

    /**
     * @throws TimezoneNotFoundException
     * @throws CityNotFoundException
     */
    public function run(GetAirportsActionRequest $request): GetAirportsActionResponse
    {
        $cities = [];

        if ($request->cityTitle) {
            $cities = $this->cityRepository->findByTitle($request->cityTitle);
        }

        $timezone = null;
        if ($request->timezone) {
            $timezone = $this->timezoneRepository->findByCode($request->timezone);

            if (!$timezone) {
                throw new TimezoneNotFoundException($request->timezone);
            }
        }

        return new GetAirportsActionResponse(
            $this->airportRepository->list(
                $request->offset,
                $request->limit,
                $request->id,
                $request->title,
                $request->iata,
                $request->icao,
                $request->isActive,
                $timezone,
                $cities,
            )
        );
    }
}
