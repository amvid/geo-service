<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Delete;

use App\Repository\SubRegionRepositoryInterface;

readonly class DeleteSubRegionAction implements DeleteSubRegionActionInterface
{
    public function __construct(private SubRegionRepositoryInterface $subRegionRepository)
    {
    }

    public function run(DeleteSubRegionActionRequest $request): DeleteSubRegionActionResponse
    {
        $exists = $this->subRegionRepository->findById($request->id);
        $res = new DeleteSubRegionActionResponse();

        if (!$exists) {
            return $res;
        }

        $this->subRegionRepository->remove($exists, true);

        return $res;
    }

}