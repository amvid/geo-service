<?php

declare(strict_types=1);

namespace App\Action\Region\Get;

use App\Entity\Region;

class GetRegionsActionResponse
{
    public array $regions;

    /**
     * @param array<Region> $regions
     */
    public function __construct(array $regions)
    {
        $this->regions = $regions;
    }
}