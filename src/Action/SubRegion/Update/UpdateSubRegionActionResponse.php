<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Update;

use App\Action\Region\Update\UpdateRegionActionResponse;
use App\Entity\SubRegion;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class UpdateSubRegionActionResponse
{
    public UuidInterface $id;
    public string $title;
    public UpdateRegionActionResponse $region;
    public DateTimeInterface $createdAt;
    public DateTimeInterface $updatedAt;

    public function __construct(SubRegion $subRegion)
    {
        $this->region = new UpdateRegionActionResponse($subRegion->getRegion());
        $this->id = $subRegion->getId();
        $this->title = $subRegion->getTitle();
        $this->createdAt = $subRegion->getCreatedAt();
        $this->updatedAt = $subRegion->getUpdatedAt();
    }
}