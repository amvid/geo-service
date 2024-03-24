<?php

declare(strict_types=1);

namespace App\City\Action\Get;

use App\City\Repository\CityRepositoryInterface;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Exception\StateNotFoundException;
use App\State\Repository\StateRepositoryInterface;

readonly class GetCitiesAction implements GetCitiesActionInterface
{
    public function __construct(
        private CityRepositoryInterface $cityRepository,
        private StateRepositoryInterface $stateRepository,
        private CountryRepositoryInterface $countryRepository,
    ) {
    }

    /**
     * @throws CountryNotFoundException
     * @throws StateNotFoundException
     */
    public function run(GetCitiesActionRequest $request): GetCitiesActionResponse
    {
        $state = null;
        if ($request->stateTitle) {
            $state = $this->stateRepository->findByTitle($request->stateTitle);

            if (!$state) {
                throw new StateNotFoundException($request->stateTitle);
            }
        }

        $country = null;

        if ($request->countryIso2) {
            $country = $this->countryRepository->findByIso2($request->countryIso2);

            if (!$country) {
                throw new CountryNotFoundException($request->countryIso2);
            }
        }

        return new GetCitiesActionResponse(
            $this->cityRepository->list(
                $request->offset,
                $request->limit,
                $request->id,
                $request->title,
                $request->iata,
                $state,
                $country
            )
        );
    }
}
