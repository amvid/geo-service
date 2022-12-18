<?php

declare(strict_types=1);

namespace App\Action\Timezone\Create;

use App\Entity\Timezone;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class CreateTimezoneActionResponse
{
    public UuidInterface $id;
    public string $title;
    public string $code;
    public string $utc;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

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