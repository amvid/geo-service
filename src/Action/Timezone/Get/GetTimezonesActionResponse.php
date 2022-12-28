<?php

declare(strict_types=1);

namespace App\Action\Timezone\Get;

use App\Controller\Response\TimezoneResponse;
use App\Entity\Timezone;

class GetTimezonesActionResponse
{
    public array $response = [];

    /**
     * @param array<Timezone> $timezones
     */
    public function __construct(array $timezones)
    {
        foreach ($timezones as $timezone) {
            $this->response[] = new TimezoneResponse($timezone);
        }
    }
}