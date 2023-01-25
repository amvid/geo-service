<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Create;

use App\Region\Exception\RegionNotFoundException;
use App\Region\Repository\RegionRepositoryInterface;
use App\SubRegion\Exception\SubRegionAlreadyExistsException;
use App\SubRegion\Factory\SubRegionFactoryInterface;
use App\SubRegion\Repository\SubRegionRepositoryInterface;

readonly class CreateSubRegionAction implements CreateSubRegionActionInterface
{
    public function __construct(
        private RegionRepositoryInterface $regionRepository,
        private SubRegionRepositoryInterface $subRegionRepository,
        private SubRegionFactoryInterface $subRegionFactory,
    ) {
    }

    /**
     * @throws RegionNotFoundException
     * @throws SubRegionAlreadyExistsException
     */
    public function run(CreateSubRegionActionRequest $request): CreateSubRegionActionResponse
    {
        $exists = $this->subRegionRepository->findByTitle($request->title);

        if ($exists) {
            throw new SubRegionAlreadyExistsException();
        }

        $region = $this->regionRepository->findByTitle($request->regionTitle);

        if (!$region) {
            throw new RegionNotFoundException($request->regionTitle);
        }

        $subRegion = $this->subRegionFactory
            ->setTitle($request->title)
            ->setRegion($region)
            ->create();

        $this->subRegionRepository->save($subRegion, true);

        return new CreateSubRegionActionResponse($subRegion);
    }
}
