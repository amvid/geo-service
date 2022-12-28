<?php

declare(strict_types=1);

namespace App\Region\Action\Delete;

use App\Region\Repository\RegionRepositoryInterface;

readonly class DeleteRegionAction implements DeleteRegionActionInterface
{
    public function __construct(private RegionRepositoryInterface $regionRepository)
    {
    }

    public function run(DeleteRegionActionRequest $request): DeleteRegionActionResponse
    {
        $exists = $this->regionRepository->findById($request->id);
        $res = new DeleteRegionActionResponse();

        if (!$exists) {
            return $res;
        }

        $this->regionRepository->remove($exists, true);

        return $res;
    }

}