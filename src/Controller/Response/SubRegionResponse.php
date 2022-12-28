<?php

declare(strict_types=1);

namespace App\Controller\Response;

use App\Entity\SubRegion;
use App\Region\Controller\Response\RegionResponse;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class SubRegionResponse
{
    public UuidInterface $id;
    public string $title;
    public RegionResponse $region;
    public DateTimeInterface $createdAt;
    public DateTimeInterface $updatedAt;

    public function __construct(SubRegion $subRegion)
    {
        $this->id = $subRegion->getId();
        $this->title = $subRegion->getTitle();
        $this->region = new RegionResponse($subRegion->getRegion());
        $this->createdAt = $subRegion->getCreatedAt();
        $this->updatedAt = $subRegion->getUpdatedAt();
    }
}