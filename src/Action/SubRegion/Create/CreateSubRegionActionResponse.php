<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Create;

use App\Controller\Response\RegionResponse;
use App\Entity\SubRegion;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class CreateSubRegionActionResponse
{
    public UuidInterface $id;
    public string $title;
    public RegionResponse $region;
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function __construct(SubRegion $subRegion)
    {
        $this->region = new RegionResponse($subRegion->getRegion());
        $this->id = $subRegion->getId();
        $this->title = $subRegion->getTitle();
        $this->createdAt = $subRegion->getCreatedAt();
        $this->updatedAt = $subRegion->getUpdatedAt();
    }
}