<?php

declare(strict_types=1);

namespace App\Airport\Action\Query;

use App\Airport\Controller\Response\QueryAirportResponse;
use App\Airport\Controller\Response\QueryChildrenAirportResponse;
use App\Airport\Entity\Airport;
use App\Airport\Repository\AirportRepositoryInterface;

readonly class QueryAirportsAction implements QueryAirportsActionInterface
{
    public function __construct(
        private AirportRepositoryInterface $airportRepository,
    ) {
    }

    public function run(QueryAirportsActionRequest $request): QueryAirportsActionResponse
    {
        /** @var array<Airport> $airports */
        $airports = $this->airportRepository->query(
            $request->offset,
            $request->limit,
            $request->query,
        );

        /** @var array<QueryChildrenAirportResponse> $res */
        $res = [];
        $map = [];

        foreach ($airports as $airport) {
            $city = $airport->getCity();
            $country = $city->getCountry();
            $cityIata = $city->getIata() ?? $airport->getIata();

            if (!isset($map[$country->getTitle()])) {
                $map[$country->getTitle()] = [];
            }
            if (!isset($map[$country->getTitle()][$cityIata])) {
                $map[$country->getTitle()][$cityIata] = [];
            }

            $map[$country->getTitle()][$cityIata][] = $airport;
        }

        foreach ($map as $countryTitle => $cities) {
            foreach ($cities as $cityIata => $airports) {
                $isGroup = count($airports) > 1;

                if ($isGroup) {
                    $cityTitle = $airports[0]->getCity()->getTitle();
                    $res[] = new QueryChildrenAirportResponse(
                        $cityTitle . ' (Any)',
                        $cityIata,
                        $countryTitle
                    );

                    $parentIndex = count($res) - 1;

                    foreach ($airports as $airport) {
                        $res[$parentIndex]->children[] = new QueryAirportResponse(
                            $airport->getTitle(),
                            $airport->getIata(),
                            $countryTitle
                        );
                    }
                } else {
                    $airport = $airports[0];
                    $res[] = new QueryAirportResponse(
                        $airport->getTitle(),
                        $airport->getIata(),
                        $countryTitle
                    );
                }
            }
        }

        return new QueryAirportsActionResponse($res);
    }
}
