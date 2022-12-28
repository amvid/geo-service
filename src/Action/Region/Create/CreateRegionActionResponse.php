<?php

declare(strict_types=1);

namespace App\Action\Region\Create;

use App\Controller\Response\RegionResponse;
use App\Entity\Region;

class CreateRegionActionResponse
{
    public RegionResponse $regionResponse;

    public function __construct(Region $region)
    {
        $this->regionResponse = new RegionResponse($region);
    }
}