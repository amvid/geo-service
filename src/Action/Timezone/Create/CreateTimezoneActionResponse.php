<?php

declare(strict_types=1);

namespace App\Action\Timezone\Create;

use App\Controller\Response\TimezoneResponse;
use App\Entity\Timezone;

class CreateTimezoneActionResponse
{
    public TimezoneResponse $timezoneResponse;

    public function __construct(Timezone $timezone)
    {
        $this->timezoneResponse = new TimezoneResponse($timezone);
    }
}