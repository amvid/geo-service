<?php

declare(strict_types=1);

namespace App\Airport\Action\Update;

use App\Airport\Controller\Response\AirportResponse;
use App\Airport\Entity\Airport;

class UpdateAirportActionResponse
{
    public AirportResponse $airport;

    public function __construct(Airport $airport)
    {
        $this->airport = new AirportResponse($airport);
    }
}
