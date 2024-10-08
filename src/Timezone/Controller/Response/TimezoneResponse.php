<?php

declare(strict_types=1);

namespace App\Timezone\Controller\Response;

use App\Timezone\Entity\Timezone;
use Ramsey\Uuid\UuidInterface;
use OpenApi\Attributes as OA;

class TimezoneResponse
{
    #[OA\Property(type: 'string', format: 'uuid')]
    public UuidInterface $id;
    public string $title;
    public string $code;
    public string $utc;

    public function __construct(Timezone $timezone)
    {
        $this->id = $timezone->getId();
        $this->title = $timezone->getTitle();
        $this->code = $timezone->getCode();
        $this->utc = $timezone->getUtc();
    }
}
