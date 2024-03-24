<?php

declare(strict_types=1);

namespace App\City\Action\Update;

use App\Application\Trait\OptionalPositionRequestTrait;
use Symfony\Component\Validator\Constraints\Length;

class UpdateCityActionRequest
{
    use OptionalPositionRequestTrait;

    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(3)]
    public ?string $iata = null;

    #[Length(2)]
    public ?string $countryIso2 = null;

    #[Length(max: 150)]
    public ?string $stateTitle = null;
}
