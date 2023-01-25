<?php

declare(strict_types=1);

namespace App\City\Action\Create;

use App\City\Factory\CityFactoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Exception\StateNotFoundException;
use App\State\Repository\StateRepositoryInterface;

readonly class CreateCityAction implements CreateCityActionInterface
{
    public function __construct(
        private CityFactoryInterface $cityFactory,
        private CityRepositoryInterface $cityRepository,
        private StateRepositoryInterface $stateRepository,
        private CountryRepositoryInterface $countryRepository,
    ) {
    }

    /**
     * @throws CountryNotFoundException
     * @throws StateNotFoundException
     */
    public function run(CreateCityActionRequest $request): CreateCityActionResponse
    {
        $country = $this->countryRepository->findByIso2($request->countryIso2);

        if (!$country) {
            throw new CountryNotFoundException($request->countryIso2);
        }

        $this->cityFactory->setCountry($country);

        if ($request->stateTitle) {
            $state = $this->stateRepository->findByTitle($request->stateTitle);

            if (!$state) {
                throw new StateNotFoundException($request->stateTitle);
            }

            $this->cityFactory->setState($state);
        }

        $city = $this->cityFactory
            ->setTitle($request->title)
            ->setAltitude($request->altitude)
            ->setLatitude($request->latitude)
            ->setLongitude($request->longitude)
            ->create();

        $this->cityRepository->save($city, true);

        return new CreateCityActionResponse($city);
    }
}
