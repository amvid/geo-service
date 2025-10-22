<?php

namespace App\Airport\Action\GetAirportsByIataCodes;

use App\Airport\Controller\Response\AirportResponse;

interface GetAirportsByIataCodesActionInterface
{
    /**
     * @return array<AirportResponse>
     */
    public function run(array $iataCodes): array;
}