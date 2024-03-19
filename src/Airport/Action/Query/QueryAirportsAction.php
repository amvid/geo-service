<?php

declare(strict_types=1);

namespace App\Airport\Action\Query;

use App\Airport\Controller\Response\QueryAirportResponse;
use App\Airport\Entity\Airport;
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
        /** @var array<Airport> $airports */
        $airports = $this->airportRepository->query(
            $request->offset,
            $request->limit,
            $request->query,
        );

        /** @var array<QueryAirportResponse> $res */
        $res = [];
        $map = [];

        foreach ($airports as $airport) {
            $city = $airport->getCity();
            $country = $city->getCountry();
            $map[$country->getTitle()][$city->getTitle()][] = $airport;
        }

        foreach ($map as $country => $cities) {
            foreach ($cities as $city => $airports) {
                $isGroup = count($airports) > 1;
                $airport = $airports[0];

                if ($isGroup) {
                    $ap = $airports[0];

                    foreach ($airports as $a) {
                        $cityEntity = $a->getCity();
                        $countryEntity = $cityEntity->getCountry();

                        if ($cityEntity === $countryEntity->getCapital()) {
                            $ap = $a;
                            break;
                        }
                    }

                    $res[] = new QueryAirportResponse(
                        $city . ' (Any)',
                        $ap->getIata(),
                        $country,
                    );
                }

                foreach ($airports as $airport) {
                    if (!$isGroup) {
                        $res[] = new QueryAirportResponse(
                            $city,
                            $airport->getIata(),
                            $country,
                        );
                        continue;
                    }

                    $res[count($res) - 1]->children[] = new QueryAirportResponse(
                        $airport->getTitle(),
                        $airport->getIata(),
                        $country,
                    );
                }
            }
        }

        return new QueryAirportsActionResponse($res);
    }
}
