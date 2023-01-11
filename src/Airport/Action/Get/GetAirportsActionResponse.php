<?php

declare(strict_types=1);

namespace App\Airport\Action\Get;

use App\Airport\Controller\Response\AirportResponse;

class GetAirportsActionResponse
{
    /**
     * @var iterable<AirportResponse>
     */
    public iterable $airports;

    public function __construct(iterable $airports)
    {
        foreach ($airports as $airport) {
            $this->airports[] = new AirportResponse($airport);
        }
    }
}