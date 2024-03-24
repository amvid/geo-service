<?php

declare(strict_types=1);

namespace App\SubRegion\Controller\Response;

use App\Region\Controller\Response\RegionResponse;
use App\SubRegion\Entity\SubRegion;
use Ramsey\Uuid\UuidInterface;
use OpenApi\Attributes as OA;

class SubRegionResponse
{
    #[OA\Property(type: 'string', format: 'uuid')]
    public UuidInterface $id;
    public string $title;
    public ?RegionResponse $region = null;

    public function __construct(SubRegion $subRegion, bool $withRelations = true)
    {
        $this->id = $subRegion->getId();
        $this->title = $subRegion->getTitle();

        if ($withRelations) {
            $this->region = new RegionResponse($subRegion->getRegion());
        }
    }
}
