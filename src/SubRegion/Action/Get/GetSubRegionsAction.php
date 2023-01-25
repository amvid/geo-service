<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Get;

use App\SubRegion\Repository\SubRegionRepositoryInterface;

readonly class GetSubRegionsAction implements GetSubRegionsActionInterface
{
    public function __construct(private SubRegionRepositoryInterface $subRegionRepository)
    {
    }

    public function run(GetSubRegionsActionRequest $request): GetSubRegionsActionResponse
    {
        return new GetSubRegionsActionResponse(
            $this->subRegionRepository->list(
                $request->offset,
                $request->limit,
                $request->title,
                $request->regionId
            )
        );
    }
}
