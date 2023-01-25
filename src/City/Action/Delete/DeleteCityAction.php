<?php

declare(strict_types=1);

namespace App\City\Action\Delete;

use App\City\Repository\CityRepositoryInterface;

readonly class DeleteCityAction implements DeleteCityActionInterface
{
    public function __construct(private CityRepositoryInterface $cityRepository)
    {
    }

    public function run(DeleteCityActionRequest $request): DeleteCityActionResponse
    {
        $exists = $this->cityRepository->findById($request->id);
        $res = new DeleteCityActionResponse();

        if (!$exists) {
            return $res;
        }

        $this->cityRepository->remove($exists, true);

        return $res;
    }
}
