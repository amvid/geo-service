<?php

declare(strict_types=1);

namespace App\Action\Region\Create;

use App\Entity\Region;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class CreateRegionActionResponse
{
    public UuidInterface $id;
    public string $title;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function __construct(Region $region)
    {
        $this->id = $region->getId();
        $this->title = $region->getTitle();
        $this->createdAt = $region->getCreatedAt();
        $this->updatedAt = $region->getUpdatedAt();
    }
}