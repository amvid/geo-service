<?php

declare(strict_types=1);

namespace App\Country\Controller\Response;

use App\Country\Entity\Country;
use App\Timezone\Entity\Timezone;
use App\Currency\Controller\Response\CurrencyResponse;
use App\SubRegion\Controller\Response\SubRegionResponse;
use App\Timezone\Controller\Response\TimezoneResponse;
use Ramsey\Uuid\UuidInterface;

class CountryResponse
{
    public UuidInterface $id;
    public string $title;
    public ?string $nativeTitle = null;
    public string $iso2;
    public string $iso3;
    public string $numericCode;
    public string $phoneCode;
    public string $flag;
    public string $tld;
    public float $longitude;
    public float $latitude;
    public ?int $altitude = null;

    public ?CurrencyResponse $currency = null;
    public ?SubRegionResponse $subRegion = null;

    /**
     * @var array<TimezoneResponse> $timezones
     */
    public ?array $timezones = null;

    public function __construct(Country $country, bool $withRelations = true)
    {
        $this->id = $country->getId();
        $this->title = $country->getTitle();
        $this->nativeTitle = $country->getNativeTitle();
        $this->iso2 = $country->getIso2();
        $this->iso3 = $country->getIso3();
        $this->numericCode = $country->getNumericCode();
        $this->phoneCode = $country->getPhoneCode();
        $this->tld = $country->getTld();
        $this->flag = $country->getFlag();
        $this->longitude = $country->getLongitude();
        $this->latitude = $country->getLatitude();
        $this->altitude = $country->getAltitude();

        if ($withRelations) {
            $this->currency = new CurrencyResponse($country->getCurrency());
            $this->subRegion = new SubRegionResponse($country->getSubRegion());

            $tzs = [];

            /** @var Timezone $timezone */
            foreach ($country->getTimezones() as $timezone) {
                $tzs[] = new TimezoneResponse($timezone);
            }

            $this->timezones = $tzs;
        }
    }
}
