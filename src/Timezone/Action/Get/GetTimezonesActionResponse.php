<?php

declare(strict_types=1);

namespace App\Timezone\Action\Get;

use App\Timezone\Controller\Response\TimezoneResponse;
use App\Timezone\Entity\Timezone;

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