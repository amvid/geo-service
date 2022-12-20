<?php

declare(strict_types=1);

namespace App\Action\SubRegion\Create;

use App\Exception\RegionNotFoundException;
use App\Exception\SubRegionAlreadyExistsException;
use App\Factory\SubRegionFactoryInterface;
use App\Repository\RegionRepositoryInterface;
use App\Repository\SubRegionRepositoryInterface;

readonly class CreateSubRegionAction implements CreateSubRegionActionInterface
{
    public function __construct(
        private RegionRepositoryInterface $regionRepository,
        private SubRegionRepositoryInterface $subRegionRepository,
        private SubRegionFactoryInterface $subRegionFactory,
    )
    {
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

        $region = $this->regionRepository->findById($request->regionId);

        if (!$region) {
            throw new RegionNotFoundException();
        }

        $subRegion = $this->subRegionFactory
            ->setTitle($request->title)
            ->setRegion($region)
            ->create();

        $this->subRegionRepository->save($subRegion, true);

        return new CreateSubRegionActionResponse($subRegion);
    }
}