<?php

declare(strict_types=1);

namespace App\Region\Action\Update;

use App\Region\Exception\RegionNotFoundException;
use App\Region\Repository\RegionRepositoryInterface;

readonly class UpdateRegionAction implements UpdateRegionActionInterface
{
    public function __construct(private RegionRepositoryInterface $regionRepository)
    {
    }

    /**
     * @throws RegionNotFoundException
     */
    public function run(UpdateRegionActionRequest $request): UpdateRegionActionResponse
    {
        $region = $this->regionRepository->findById($request->id);

        if (!$region) {
            throw new RegionNotFoundException($request->id->toString());
        }

        $region->setTitle($request->title);
        $this->regionRepository->save($region, true);

        return new UpdateRegionActionResponse($region);
    }

}