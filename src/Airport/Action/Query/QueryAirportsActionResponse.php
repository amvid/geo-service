<?php

declare(strict_types=1);

namespace App\Airport\Action\Query;

use App\Airport\Controller\Response\QueryAirportResponse;
use App\Airport\Entity\Airport;

class QueryAirportsActionResponse
{
    /**
     * @var iterable<QueryAirportResponse>
     */
    public iterable $airports = [];

    /** @param iterable<Airport> $airports */
    public function __construct(iterable $airports)
    {
        $citiesAirportsMap = [];

        foreach ($airports as $airport) {
            $city = $airport->getCity();
            $citiesAirportsMap[$city->getTitle()][] = $airport;
        }

        foreach ($citiesAirportsMap as $city => $airports) {
            $isGroup = count($airports) > 1;
            if ($isGroup) {
                $airport = $airports[0];
                $this->airports[] = new QueryAirportResponse(
                    $city . ' (Any)',
                    $airport->getIata(),
                    $airport->getCity()->getCountry()->getTitle()
                );
            }

            foreach ($airports as $airport) {
                $city = $airport->getCity();
                $country = $city->getCountry();

                if (!$isGroup) {
                    $this->airports[] = new QueryAirportResponse($airport->getTitle(), $airport->getIata(), $country->getTitle());
                    continue;
                }

                $this->airports[count($this->airports) - 1]->children[] = new QueryAirportResponse(
                    $airport->getTitle(),
                    $airport->getIata(),
                    $country->getTitle()
                );
            }
        }
    }
}
