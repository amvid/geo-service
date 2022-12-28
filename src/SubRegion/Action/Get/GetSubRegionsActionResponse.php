<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Get;

use App\SubRegion\Controller\Response\SubRegionResponse;
use App\SubRegion\Entity\SubRegion;

class GetSubRegionsActionResponse
{
    public array $response = [];

    /**
     * @param array<SubRegion> $subRegions
     */
    public function __construct(array $subRegions)
    {
        foreach ($subRegions as $subRegion) {
            $this->response[] = new SubRegionResponse($subRegion);
        }
    }
}