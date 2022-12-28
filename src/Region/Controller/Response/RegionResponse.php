<?php

declare(strict_types=1);

namespace App\Region\Controller\Response;

use App\Region\Entity\Region;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class RegionResponse
{
    public UuidInterface $id;
    public string $title;
    public DateTimeInterface $createdAt;
    public DateTimeInterface $updatedAt;

    public function __construct(Region $region)
    {
        $this->id = $region->getId();
        $this->title = $region->getTitle();
        $this->createdAt = $region->getCreatedAt();
        $this->updatedAt = $region->getUpdatedAt();
    }
}