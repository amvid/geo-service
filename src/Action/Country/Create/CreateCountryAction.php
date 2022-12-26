<?php

declare(strict_types=1);

namespace App\Action\Country\Create;

use App\Exception\CountryAlreadyExistsException;
use App\Exception\CurrencyNotFoundException;
use App\Exception\SubRegionNotFoundException;
use App\Exception\TimezoneNotFoundException;
use App\Factory\CountryFactoryInterface;
use App\Repository\CountryRepositoryInterface;
use App\Repository\CurrencyRepositoryInterface;
use App\Repository\SubRegionRepositoryInterface;
use App\Repository\TimezoneRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;

readonly class CreateCountryAction implements CreateCountryActionInterface
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