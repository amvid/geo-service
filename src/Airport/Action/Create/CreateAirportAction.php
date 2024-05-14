<?php

declare(strict_types=1);

namespace App\Airport\Action\Create;

use App\Airport\Exception\AirportAlreadyExistsException;
use App\Airport\Factory\AirportFactoryInterface;
use App\Airport\Repository\AirportRepositoryInterface;
use App\City\Exception\CityNotFoundException;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;

readonly class CreateAirportAction implements CreateAirportActionInterface
{
    public function __construct(
        private AirportFactoryInterface $airportFactory,
        private AirportRepositoryInterface $airportRepository,
        private CityRepositoryInterface $cityRepository,
        private CountryRepositoryInterface $countryRepository,
        private TimezoneRepositoryInterface $timezoneRepository,
    ) {
    }

    /**
     * @throws TimezoneNotFoundException
     * @throws CityNotFoundException
     * @throws AirportAlreadyExistsException
     */
    public function run(CreateAirportActionRequest $request): CreateAirportActionResponse
    {
        $exists = $this->airportRepository->findByIata($request->iata);

        if ($exists) {
            throw new AirportAlreadyExistsException();
        }

        $country = $this->countryRepository->findByIso2($request->countryIso2);

        if (!$country) {
            throw new CountryNotFoundException($request->countryIso2);
        }

        $city = $this->cityRepository->findByTitleAndCountry($request->cityTitle, $country);

        if (!$city) {
            throw new CityNotFoundException($request->cityTitle);
        }

        $timezone = $this->timezoneRepository->findByCode($request->timezone);

        if (!$timezone) {
            throw new TimezoneNotFoundException($request->timezone);
        }

        $airport = $this->airportFactory
            ->setIata($request->iata)
            ->setIcao($request->icao)
            ->setRank($request->rank)
            ->setTitle($request->title)
            ->setLatitude($request->latitude)
            ->setLongitude($request->longitude)
            ->setAltitude($request->altitude)
            ->setCity($city)
            ->setTimezone($timezone)
            ->create();

        $this->airportRepository->save($airport, true);

        return new CreateAirportActionResponse($airport);
    }
}
