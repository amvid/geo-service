<?php

declare(strict_types=1);

namespace App\State\Action\Create;

use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\State\Exception\StateAlreadyExistsException;
use App\State\Factory\StateFactoryInterface;
use App\State\Repository\StateRepositoryInterface;

readonly class CreateStateAction implements CreateStateActionInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
        private StateRepositoryInterface   $stateRepository,
        private StateFactoryInterface      $stateFactory,
    )
    {
    }

    /**
     * @throws CountryNotFoundException
     * @throws StateAlreadyExistsException
     */
    public function run(CreateStateActionRequest $request): CreateStateActionResponse
    {
        $exists = $this->stateRepository->findByTitle($request->title);

        if ($exists) {
            throw new StateAlreadyExistsException();
        }

        $country = $this->countryRepository->findByIso2($request->countryIso2);

        if (!$country) {
            throw new CountryNotFoundException($request->countryIso2);
        }

        $state = $this->stateFactory
            ->setType($request->type)
            ->setCountry($country)
            ->setLongitude($request->longitude)
            ->setLatitude($request->latitude)
            ->setAltitude($request->altitude)
            ->setCode($request->code)
            ->setTitle($request->title)
            ->create();

        $this->stateRepository->save($state, true);

        return new CreateStateActionResponse($state);
    }
}