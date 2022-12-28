<?php

declare(strict_types=1);

namespace App\Action\Country\Update;

use App\Currency\Exception\CurrencyNotFoundException;
use App\Currency\Repository\CurrencyRepositoryInterface;
use App\Exception\CountryNotFoundException;
use App\Factory\CountryFactoryInterface;
use App\Repository\CountryRepositoryInterface;
use App\SubRegion\Exception\SubRegionNotFoundException;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

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

        if ($request->subRegion) {
            $subRegion = $this->subRegionRepository->findByTitle($request->subRegion);

            if (!$subRegion) {
                throw new SubRegionNotFoundException($request->subRegion);
            }

            $this->countryFactory->setSubRegion($subRegion);
        }

        if ($request->currencyCode) {
            $currency = $this->currencyRepository->findByCode($request->currencyCode);

            if (!$currency) {
                throw new CurrencyNotFoundException($request->currencyCode);
            }

            $this->countryFactory->setCurrency($currency);
        }

        if ($request->timezones) {
            $tzs = new ArrayCollection();

            foreach ($request->timezones as $tzCode) {
                $timezone = $this->timezoneRepository->findByCode($tzCode);

                if (!$timezone) {
                    throw new TimezoneNotFoundException($tzCode);
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
