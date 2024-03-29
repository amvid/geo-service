<?php

declare(strict_types=1);

namespace App\City\Action\Update;

use App\City\Exception\CityAlreadyExistsException;
use App\City\Exception\CityNotFoundException;
use App\City\Factory\CityFactoryInterface;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Exception\StateNotFoundException;
use App\State\Repository\StateRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

readonly class UpdateCityAction implements UpdateCityActionInterface
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
     * @throws CityAlreadyExistsException
     * @throws CityNotFoundException
     * @throws StateNotFoundException
     */
    public function run(UpdateCityActionRequest $request, UuidInterface $id): UpdateCityActionResponse
    {
        $country = null;
        $city = $this->cityRepository->findById($id);

        if (!$city) {
            throw new CityNotFoundException($id->toString());
        }

        $this->cityFactory->setCity($city);

        if ($request->iata) {
            $existingCityByIata = $this->cityRepository->findByIata($request->iata);

            if ($existingCityByIata) {
                throw new CityAlreadyExistsException($request->iata);
            }
        }

        if ($request->stateTitle) {
            $state = $this->stateRepository->findByTitle($request->stateTitle);

            if (!$state) {
                throw new StateNotFoundException($request->stateTitle);
            }

            $this->cityFactory->setState($state);
        }

        if ($request->countryIso2) {
            $country = $this->countryRepository->findByIso2($request->countryIso2);

            if (!$country) {
                throw new CountryNotFoundException($request->countryIso2);
            }

            $this->cityFactory->setCountry($country);
        }

        if ($request->title) {
            $exists = $this->cityRepository->findByTitleAndCountry($request->title, $country);

            if ($exists && $exists->getId() !== $city->getId()) {
                throw new CityAlreadyExistsException($request->title);
            }

            $this->cityFactory->setTitle($request->title);
        }

        if ($request->longitude) {
            $this->cityFactory->setLongitude($request->longitude);
        }

        if ($request->latitude) {
            $this->cityFactory->setLatitude($request->latitude);
        }

        if ($request->altitude) {
            $this->cityFactory->setAltitude($request->altitude);
        }

        $city = $this->cityFactory->create();
        $this->cityRepository->save($city, true);

        return new UpdateCityActionResponse($city);
    }
}
