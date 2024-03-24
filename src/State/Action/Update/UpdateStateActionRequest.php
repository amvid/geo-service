<?php

declare(strict_types=1);

namespace App\State\Action\Update;

use Symfony\Component\Validator\Constraints\Length;

class UpdateStateActionRequest
{
    #[Length(min: 1, max: 150)]
    public ?string $title = null;

    #[Length(min: 1, max: 50)]
    public ?string $type = null;

    public ?float $longitude = null;

    public ?float $latitude = null;

    public ?int $altitude = null;

    #[Length(2)]
    public ?string $countryIso2 = null;
}
