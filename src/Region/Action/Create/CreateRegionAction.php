<?php

declare(strict_types=1);

namespace App\Region\Action\Create;

use App\Region\Exception\RegionAlreadyExistsException;
use App\Region\Factory\RegionFactoryInterface;
use App\Region\Repository\RegionRepositoryInterface;

readonly class CreateRegionAction implements CreateRegionActionInterface
{
    public function __construct(
        private RegionRepositoryInterface $regionRepository,
        private RegionFactoryInterface $regionFactory,
    )
    {
    }

    /**
     * @throws RegionAlreadyExistsException
     */
    public function run(CreateRegionActionRequest $request): CreateRegionActionResponse
    {
        $exists = $this->regionRepository->findByTitle($request->title);

        if ($exists) {
            throw new RegionAlreadyExistsException();
        }

        $region = $this->regionFactory
            ->setTitle($request->title)
            ->create();

        $this->regionRepository->save($region, true);

        return new CreateRegionActionResponse($region);
    }
}