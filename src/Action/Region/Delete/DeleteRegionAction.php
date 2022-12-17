<?php

declare(strict_types=1);

namespace App\Action\Region\Delete;

use App\Repository\RegionRepositoryInterface;

readonly class DeleteRegionAction implements DeleteRegionActionInterface
{
    public function __construct(private RegionRepositoryInterface $regionRepository)
    {
    }

    public function run(DeleteRegionActionRequest $request): DeleteRegionActionResponse
    {
        $exists = $this->regionRepository->findByTitle($request->title);
        $res = new DeleteRegionActionResponse();

        if (!$exists) {
            return $res;
        }

        $this->regionRepository->remove($exists, true);

        return $res;
    }

}