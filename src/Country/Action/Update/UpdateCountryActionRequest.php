<?php

declare(strict_types=1);

namespace App\Country\Action\Update;

use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;

class UpdateCountryActionRequest
{
    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(min: 1, max: 150)]
    public ?string $nativeTitle = null;

    #[Length(min: 1, max: 20)]
    public ?string $phoneCode = null;

    #[Length(min: 1, max: 150)]
    public ?string $subRegion = null;

    #[Length(min: 1, max: 3)]
    public ?string $currencyCode = null;

    #[Length(min: 1, max: 100)]
    public ?string $flag = null;

    #[Length(min: 1, max: 20)]
    public ?string $tld = null;

    /**
     * @param array<string> $timezones
     */
    #[Count(min: 1)]
    public ?array $timezones = null;

    public ?float $latitude = null;

    public ?float $longitude = null;

    public ?int $altitude = null;
}
