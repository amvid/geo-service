<?php

declare(strict_types=1);

namespace App\Airport\Action\Create;

use App\Airport\Controller\Response\AirportResponse;
use App\Airport\Entity\Airport;

class CreateAirportActionResponse
{
    public AirportResponse $airport;

    public function __construct(Airport $airport)
    {
        $this->airport = new AirportResponse($airport);
    }
}
