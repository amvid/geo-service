<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Update;

use App\Region\Exception\RegionNotFoundException;
use App\Region\Repository\RegionRepositoryInterface;
use App\SubRegion\Exception\SubRegionNotFoundException;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

readonly class UpdateSubRegionAction implements UpdateSubRegionActionInterface
{
    public function __construct(
        private SubRegionRepositoryInterface $subRegionRepository,
        private RegionRepositoryInterface $regionRepository,
    ) {
    }

    /**
     * @throws RegionNotFoundException
     * @throws SubRegionNotFoundException
     */
    public function run(UpdateSubRegionActionRequest $request, UuidInterface $id): UpdateSubRegionActionResponse
    {
        $subRegion = $this->subRegionRepository->findById($id);

        if (!$subRegion) {
            throw new SubRegionNotFoundException($id->toString());
        }

        if ($request->regionTitle) {
            $region = $this->regionRepository->findByTitle($request->regionTitle);

            if (!$region) {
                throw new RegionNotFoundException($request->regionTitle);
            }

            $subRegion->setRegion($region);
        }

        $subRegion->setTitle($request->title);
        $this->subRegionRepository->save($subRegion, true);

        return new UpdateSubRegionActionResponse($subRegion);
    }
}
