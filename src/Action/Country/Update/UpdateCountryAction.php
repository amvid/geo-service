<?php

declare(strict_types=1);

namespace App\Action\Country\Update;

use App\Exception\CountryNotFoundException;
use App\Exception\CurrencyNotFoundException;
use App\Exception\SubRegionNotFoundException;
use App\Exception\TimezoneNotFoundException;
use App\Factory\CountryFactoryInterface;
use App\Repository\CountryRepositoryInterface;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\SubRegionRepositoryInterface;
use App\Repository\TimezoneRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

readonly class UpdateCountryAction implements UpdateCountryActionInterface
{
    public function __construct(
        private CountryFactoryInterface      $countryFactory,
        private CountryRepositoryInterface   $countryRepository,
        private TimezoneRepositoryInterface  $timezoneRepository,
        private CurrencyRepositoryInterface  $currencyRepository,
        private SubRegionRepositoryInterface $subRegionRepository,
    )
    {
    }

    /**
     * @throws CurrencyNotFoundException
     * @throws SubRegionNotFoundException
     * @throws TimezoneNotFoundException
     * @throws CountryNotFoundException
     */
    public function run(UpdateCountryActionRequest $request): UpdateCountryActionResponse
    {
        $exists = $this->countryRepository->findById($request->id);

        if (!$exists) {
            throw new CountryNotFoundException($request->id->toString());
        }

        $this->countryFactory->setCountry($exists);

        if ($request->subRegionId) {
            $subRegion = $this->subRegionRepository->findById($request->subRegionId);

            if (!$subRegion) {
                throw new SubRegionNotFoundException($request->subRegionId->toString());
            }

            $this->countryFactory->setSubRegion($subRegion);
        }

        if ($request->currencyId) {
            $currency = $this->currencyRepository->findById($request->currencyId);

            if (!$currency) {
                throw new CurrencyNotFoundException($request->currencyId->toString());
            }

            $this->countryFactory->setCurrency($currency);
        }

        if ($request->timezones) {
            $tzs = new ArrayCollection();

            /** @var UuidInterface $tzId */
            foreach ($request->timezones as $tzId) {
                $timezone = $this->timezoneRepository->findById($tzId);

                if (!$timezone) {
                    throw new TimezoneNotFoundException($tzId->toString());
                }

                $tzs->add($timezone);
            }

            $this->countryFactory->setTimezones($tzs);
        }

        if ($request->nativeTitle) {
            $this->countryFactory->setNativeTitle($request->nativeTitle);
        }

        if ($request->flag) {
            $this->countryFactory->setFlag($request->flag);
        }

        if ($request->phoneCode) {
            $this->countryFactory->setPhoneCode($request->phoneCode);
        }

        if ($request->longitude) {
            $this->countryFactory->setLongitude($request->longitude);
        }

        if ($request->latitude) {
            $this->countryFactory->setLatitude($request->latitude);
        }

        if ($request->tld) {
            $this->countryFactory->setTld($request->tld);
        }

        if ($request->altitude) {
            $this->countryFactory->setAltitude($request->altitude);
        }

        $country = $this->countryFactory->create();
        $this->countryRepository->save($country, true);

        return new UpdateCountryActionResponse($country);
    }
}
