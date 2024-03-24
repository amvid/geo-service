<?php

declare(strict_types=1);

namespace App\Region\Controller\Response;

use App\Region\Entity\Region;
use Ramsey\Uuid\UuidInterface;
use OpenApi\Attributes as OA;

class RegionResponse
{
    #[OA\Property(type: 'string', format: 'uuid')]
    public UuidInterface $id;
    public string $title;

    public function __construct(Region $region)
    {
        $this->id = $region->getId();
        $this->title = $region->getTitle();
    }
}
