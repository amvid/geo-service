<?php

declare(strict_types=1);

namespace App\Controller\Response;

use App\Entity\Timezone;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class TimezoneResponse
{
    public UuidInterface $id;
    public string $title;
    public string $code;
    public string $utc;
    public DateTimeInterface $createdAt;
    public DateTimeInterface $updatedAt;

    public function __construct(Timezone $timezone)
    {
        $this->id = $timezone->getId();
        $this->title = $timezone->getTitle();
        $this->code = $timezone->getCode();
        $this->utc = $timezone->getUtc();
        $this->createdAt = $timezone->getCreatedAt();
        $this->updatedAt = $timezone->getUpdatedAt();
    }
}