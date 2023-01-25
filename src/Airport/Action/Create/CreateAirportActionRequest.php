<?php

declare(strict_types=1);

namespace App\Airport\Action\Create;

use App\Application\Trait\PositionRequestTrait;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateAirportActionRequest
{
    use PositionRequestTrait;

    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;

    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $cityTitle;

    #[NotBlank]
    #[Length(3)]
    public string $iata;

    #[NotBlank]
    #[Length(4)]
    public string $icao;

    #[NotBlank]
    #[Length(max: 150)]
    public string $timezone;
}
