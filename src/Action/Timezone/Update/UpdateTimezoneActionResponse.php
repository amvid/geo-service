<?php

declare(strict_types=1);

namespace App\Action\Timezone\Update;

use App\Controller\Response\TimezoneResponse;
use App\Entity\Timezone;

readonly class UpdateTimezoneActionResponse
{
    public TimezoneResponse $timezoneResponse;

    public function __construct(Timezone $timezone)
    {
        $this->timezoneResponse = new TimezoneResponse($timezone);
    }
}