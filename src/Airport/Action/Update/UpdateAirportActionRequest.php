<?php

declare(strict_types=1);

namespace App\Airport\Action\Update;

use App\Application\Trait\OptionalPositionRequestTrait;
use Symfony\Component\Validator\Constraints\Length;

class UpdateAirportActionRequest
{
    use OptionalPositionRequestTrait;

    #[Length(4)]
    public ?string $icao = null;

    #[Length(3)]
    public ?string $iata = null;

    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(min: 1, max: 150)]
    public ?string $cityTitle = null;

    #[Length(2)]
    public ?string $countryIso2 = null;

    #[Length(min: 1, max: 150)]
    public ?string $timezone = null;

    public ?bool $isActive = null;

    public ?float $rank = null;
}
