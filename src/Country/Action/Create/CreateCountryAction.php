<?php

declare(strict_types=1);

namespace App\Country\Action\Create;

use App\Country\Exception\CountryAlreadyExistsException;
use App\Country\Factory\CountryFactoryInterface;
use App\Country\Repository\CountryRepositoryInterface;
use App\Currency\Exception\CurrencyNotFoundException;
use App\Currency\Repository\CurrencyRepositoryInterface;
use App\SubRegion\Exception\SubRegionNotFoundException;
use App\SubRegion\Repository\SubRegionRepositoryInterface;
use App\Timezone\Exception\TimezoneNotFoundException;
use App\Timezone\Repository\TimezoneRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

readonly class CreateCountryAction implements CreateCountryActionInterface
{
    public function __construct(
        private CountryFactoryInterface $countryFactory,
        private CountryRepositoryInterface $countryRepository,
        private TimezoneRepositoryInterface $timezoneRepository,
        private CurrencyRepositoryInterface $currencyRepository,
        private SubRegionRepositoryInterface $subRegionRepository,
    ) {
    }

    /**
     * @throws CountryAlreadyExistsException
     * @throws CurrencyNotFoundException
     * @throws SubRegionNotFoundException
     * @throws TimezoneNotFoundException
     */
    public function run(CreateCountryActionRequest $request): CreateCountryActionResponse
    {
        $exists = $this->countryRepository->findByIso2($request->iso2);

        if ($exists) {
            throw new CountryAlreadyExistsException();
        }

        $subRegion = $this->subRegionRepository->findByTitle($request->subRegion);

        if (!$subRegion) {
            throw new SubRegionNotFoundException($request->subRegion);
        }

        $currency = $this->currencyRepository->findByCode($request->currencyCode);

        if (!$currency) {
            throw new CurrencyNotFoundException($request->currencyCode);
        }

        $tzs = new ArrayCollection();

        foreach ($request->timezones as $tz) {
            $timezone = $this->timezoneRepository->findByCode($tz);

            if (!$timezone) {
                throw new TimezoneNotFoundException($tz);
            }

            $tzs->add($timezone);
        }

        $country = $this->countryFactory
            ->setSubRegion($subRegion)
            ->setCurrency($currency)
            ->setTimezones($tzs)
            ->setIso2($request->iso2)
            ->setIso3($request->iso3)
            ->setNumericCode($request->numericCode)
            ->setTitle($request->title)
            ->setNativeTitle($request->nativeTitle)
            ->setFlag($request->flag)
            ->setPhoneCode($request->phoneCode)
            ->setLatitude($request->latitude)
            ->setLongitude($request->longitude)
            ->setAltitude($request->altitude)
            ->setTld($request->tld)
            ->create();

        $this->countryRepository->save($country, true);

        return new CreateCountryActionResponse($country);
    }
}
