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
    ) {}

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
        $regions = [];
        $subregions = [];

        foreach ($airports as $airport) {
            $city = $airport->getCity();
            $country = $city->getCountry();
            $subregion = $country->getSubregion();
            $region = $subregion?->getRegion();
            $cityIata = $city->getIata() ?? $airport->getIata();

            $regions[$country->getTitle()] = $region?->getTitle();
            $subregions[$country->getTitle()] = $subregion?->getTitle();

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
                        $countryTitle,
                        $regions[$countryTitle],
                        $subregions[$countryTitle],
                    );

                    $parentIndex = count($res) - 1;

                    foreach ($airports as $airport) {
                        $res[$parentIndex]->children[] = new QueryAirportResponse(
                            $airport->getTitle(),
                            $airport->getIata(),
                            $countryTitle,
                            $regions[$countryTitle],
                            $subregions[$countryTitle],
                        );
                    }
                } else {
                    $airport = $airports[0];
                    $res[] = new QueryAirportResponse(
                        $airport->getTitle(),
                        $airport->getIata(),
                        $countryTitle,
                        $regions[$countryTitle],
                        $subregions[$countryTitle],
                    );
                }
            }
        }

        return new QueryAirportsActionResponse($res);
    }
}
