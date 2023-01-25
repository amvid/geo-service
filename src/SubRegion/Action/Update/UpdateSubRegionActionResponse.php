<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Update;

use App\SubRegion\Controller\Response\SubRegionResponse;
use App\SubRegion\Entity\SubRegion;

class UpdateSubRegionActionResponse
{
    public SubRegionResponse $subRegionResponse;

    public function __construct(SubRegion $subRegion)
    {
        $this->subRegionResponse = new SubRegionResponse($subRegion);
    }
}
