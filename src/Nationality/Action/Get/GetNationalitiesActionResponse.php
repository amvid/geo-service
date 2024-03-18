<?php

declare(strict_types=1);

namespace App\Nationality\Action\Get;

use App\Nationality\Controller\Response\NationalityResponse;
use App\Nationality\Entity\Nationality;

class GetNationalitiesActionResponse
{
    public array $response = [];

    /**
     * @param array<Nationality> $nationalities
     */
    public function __construct(array $nationalities)
    {
        foreach ($nationalities as $nationality) {
            $this->response[] = new NationalityResponse($nationality);
        }
    }
}
