<?php

declare(strict_types=1);

namespace App\Region\Action\Update;

use App\Region\Exception\RegionNotFoundException;
use App\Region\Repository\RegionRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

readonly class UpdateRegionAction implements UpdateRegionActionInterface
{
    public function __construct(private RegionRepositoryInterface $regionRepository)
    {
    }

    /**
     * @throws RegionNotFoundException
     */
    public function run(UpdateRegionActionRequest $request, UuidInterface $id): UpdateRegionActionResponse
    {
        $region = $this->regionRepository->findById($id);

        if (!$region) {
            throw new RegionNotFoundException($id->toString());
        }

        $region->setTitle($request->title);
        $this->regionRepository->save($region, true);

        return new UpdateRegionActionResponse($region);
    }
}
