<?php

declare(strict_types=1);

namespace App\Action\Region\Get;

use App\Repository\RegionRepositoryInterface;

readonly class GetRegionsAction implements GetRegionsActionInterface
{
    public function __construct(private RegionRepositoryInterface $regionRepository)
    {
    }

    public function run(GetRegionsActionRequest $request): GetRegionsActionResponse
    {
        return new GetRegionsActionResponse(
            $this->regionRepository->list($request->offset, $request->limit, $request->title)
        );
    }

}