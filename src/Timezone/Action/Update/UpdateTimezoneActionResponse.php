<?php

declare(strict_types=1);

namespace App\Timezone\Action\Update;

use App\Timezone\Controller\Response\TimezoneResponse;
use App\Timezone\Entity\Timezone;

class UpdateTimezoneActionResponse
{
    public TimezoneResponse $timezoneResponse;

    public function __construct(Timezone $timezone)
    {
        $this->timezoneResponse = new TimezoneResponse($timezone);
    }
}