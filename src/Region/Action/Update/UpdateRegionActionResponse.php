<?php

declare(strict_types=1);

namespace App\Region\Action\Update;

use App\Region\Controller\Response\RegionResponse;
use App\Region\Entity\Region;

class UpdateRegionActionResponse
{
    public RegionResponse $regionResponse;

    public function __construct(Region $region)
    {
        $this->regionResponse = new RegionResponse($region);
    }
}
