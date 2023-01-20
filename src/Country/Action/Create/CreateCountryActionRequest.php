<?php

declare(strict_types=1);

namespace App\Country\Action\Create;

use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateCountryActionRequest
{
    #[NotBlank]
    #[Length(2)]
    public string $iso2;

    #[NotBlank]
    #[Length(3)]
    public string $iso3;

    #[NotBlank]
    #[Length(min: 1, max: 3)]
    public string $numericCode;

    #[NotBlank]
    #[Length(min: 1, max: 20)]
    public string $phoneCode;

    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;

    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $subRegion;

    #[NotBlank]
    #[Length(min: 1, max: 3)]
    public string $currencyCode;

    #[NotBlank]
    #[Length(min: 1, max: 100)]
    public string $flag;

    #[NotBlank]
    #[Length(min: 1, max: 20)]
    public string $tld;

    #[NotBlank]
    public float $latitude;

    #[NotBlank]
    public float $longitude;

    /**
     * Array of timezone codes: "Europe/Oslo"
     */
    #[NotBlank]
    #[Count(min: 1)]
    public array $timezones;

    public ?int $altitude = null;

    #[Length(min: 1, max: 150)]
    public ?string $nativeTitle = null;
}
