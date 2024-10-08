<?php

declare(strict_types=1);

namespace App\City\Action\Create;

use App\Application\Trait\PositionRequestTrait;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateCityActionRequest
{
    use PositionRequestTrait;

    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;

    #[Length(3)]
    public ?string $iata = null;

    #[NotBlank]
    #[Length(2)]
    public string $countryIso2;

    #[Length(max: 150)]
    public ?string $stateTitle = null;
}
