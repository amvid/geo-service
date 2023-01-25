<?php

declare(strict_types=1);

namespace App\State\Action\Update;

use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Exception\StateNotFoundException;
use App\State\Factory\StateFactoryInterface;
use App\State\Repository\StateRepositoryInterface;

readonly class UpdateStateAction implements UpdateStateActionInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
        private StateRepositoryInterface $stateRepository,
        private StateFactoryInterface $stateFactory,
    ) {
    }

    /**
     * @throws StateNotFoundException
     * @throws CountryNotFoundException
     */
    public function run(UpdateStateActionRequest $request): UpdateStateActionResponse
    {
        $state = $this->stateRepository->findById($request->id);

        if (!$state) {
            throw new StateNotFoundException($request->id->toString());
        }

        $this->stateFactory->setState($state);

        if ($request->title) {
            $this->stateFactory->setTitle($request->title);
        }

        if ($request->type) {
            $this->stateFactory->setType($request->type);
        }

        if ($request->longitude) {
            $this->stateFactory->setLongitude($request->longitude);
        }

        if ($request->latitude) {
            $this->stateFactory->setLatitude($request->latitude);
        }

        if ($request->altitude) {
            $this->stateFactory->setAltitude($request->altitude);
        }

        if ($request->countryIso2) {
            $country = $this->countryRepository->findByIso2($request->countryIso2);

            if (!$country) {
                throw new CountryNotFoundException($request->countryIso2);
            }

            $this->stateFactory->setCountry($country);
        }

        $this->stateRepository->save($state, true);

        return new UpdateStateActionResponse($state);
    }
}
