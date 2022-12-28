<?php

declare(strict_types=1);

namespace App\Action\Region\Get;

use App\Controller\Response\RegionResponse;
use App\Entity\Region;

class GetRegionsActionResponse
{
    public array $response;

    /**
     * @param array<Region> $regions
     */
    public function __construct(array $regions)
    {
        foreach ($regions as $region) {
            $this->response[] = new RegionResponse($region);
        }
    }
}