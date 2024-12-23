<?php

declare(strict_types=1);

namespace App\Airport\Action\Update;

use App\Airport\Exception\AirportNotFoundException;
use App\Airport\Factory\AirportFactoryInterface;
use App\Airport\Repository\AirportRepositoryInterface;
use App\City\Exception\CityNotFoundException;
use App\City\Repository\CityRepositoryInterface;
use App\Country\Exception\CountryNotFoundException;
use App\Country\Repository\CountryRepositoryInterface;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class UpdateAirportAction implements UpdateAirportActionInterface
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
     * @throws AirportNotFoundException
     * @throws CityNotFoundException
     */
    public function run(UpdateAirportActionRequest $request, UuidInterface $id): UpdateAirportActionResponse
    {
        $airport = $this->airportRepository->findById($id);

        if (!$airport) {
            throw new AirportNotFoundException($id->toString());
        }

        $this->airportFactory->setAirport($airport);

        if ($request->cityTitle && $airport->getCity()->getTitle() !== $request->cityTitle) {
            if (!$request->countryIso2) {
                throw new BadRequestHttpException('Country ISO2 is required when updating city title');
            }

            $country = $this->countryRepository->findByIso2($request->countryIso2);

            if (!$country) {
                throw new CountryNotFoundException($request->countryIso2);
            }

            $city = $this->cityRepository->findByTitleAndCountry($request->cityTitle, $country);

            if (!$city) {
                throw new CityNotFoundException($request->cityTitle);
            }

            $this->airportFactory->setCity($city);
        }

        if ($request->timezone && $airport->getTimezone()->getCode() !== $request->timezone) {
            $timezone = $this->timezoneRepository->findByCode($request->timezone);

            if (!$timezone) {
                throw new TimezoneNotFoundException($request->timezone);
            }

            $this->airportFactory->setTimezone($timezone);
        }

        if ($request->rank) {
            $this->airportFactory->setRank($request->rank);
        }

        if ($request->icao) {
            $this->airportFactory->setIcao($request->icao);
        }

        if ($request->iata) {
            $this->airportFactory->setIata($request->iata);
        }

        if ($request->title) {
            $this->airportFactory->setTitle($request->title);
        }

        if ($request->longitude) {
            $this->airportFactory->setLongitude($request->longitude);
        }

        if ($request->latitude) {
            $this->airportFactory->setLatitude($request->latitude);
        }

        if ($request->altitude) {
            $this->airportFactory->setAltitude($request->altitude);
        }

        if (null !== $request->isActive) {
            $this->airportFactory->setIsActive($request->isActive);
        }

        $this->airportRepository->save($this->airportFactory->create(), true);
        return new UpdateAirportActionResponse($airport);
    }
}
