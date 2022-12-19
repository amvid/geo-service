<?php

declare(strict_types=1);

namespace App\Action\Timezone\Get;

use App\Entity\Timezone;

class GetTimezonesActionResponse
{
    public array $timezones;

    /**
     * @param array<Timezone> $timezones
     */
    public function __construct(array $timezones)
    {
        $this->timezones = $timezones;
    }
}