<?php

declare(strict_types=1);

namespace App\Airport\Action\GetAirportsByIataCodes;

use App\Airport\Controller\Response\AirportResponse;
use App\Airport\Repository\AirportRepositoryInterface;

final readonly class GetAirportsByIataCodesAction implements GetAirportsByIataCodesActionInterface
{
    public function __construct(private AirportRepositoryInterface $airportRepository)
    {
    }

    /**
     * @return array<AirportResponse>
     */
    public function run(array $iataCodes = []): array
    {
        if (empty($iataCodes)) {
            return [];
        }

        $result = [];

        foreach ($iataCodes as $iataCode) {
            $airport = $this->airportRepository->findByIata($iataCode);

            if ($airport) {
                $result[$iataCode] = new AirportResponse($airport);
            } else {
                $result[$iataCode] = null;
            }
        }

        return $result;
    }
}