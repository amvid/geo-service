<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Get;

use App\Controller\Response\SubRegionResponse;
use App\Entity\SubRegion;

class GetSubRegionsActionResponse
{
    public array $response;

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