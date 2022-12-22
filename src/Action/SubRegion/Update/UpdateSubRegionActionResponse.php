<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Update;

use App\Controller\Response\SubRegionResponse;
use App\Entity\SubRegion;

class UpdateSubRegionActionResponse
{
    public SubRegionResponse $subRegionResponse;

    public function __construct(SubRegion $subRegion)
    {
        $this->subRegionResponse = new SubRegionResponse($subRegion);
    }
}