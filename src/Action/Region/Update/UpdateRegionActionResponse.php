<?php

declare(strict_types=1);

namespace App\Action\Region\Update;

use App\Controller\Response\RegionResponse;
use App\Entity\Region;

class UpdateRegionActionResponse
{
    public RegionResponse $regionResponse;

    public function __construct(Region $region)
    {
        $this->regionResponse = new RegionResponse($region);
    }
}