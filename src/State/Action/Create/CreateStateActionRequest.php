<?php

declare(strict_types=1);

namespace App\State\Action\Create;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateStateActionRequest
{
    #[NotBlank]
    #[Length(min: 1, max: 150)]
    public string $title;

    #[NotBlank]
    #[Length(min: 1, max: 5)]
    public string $code;

    #[NotBlank]
    #[Length(2)]
    public string $countryIso2;

    #[NotBlank]
    public float $longitude;

    #[NotBlank]
    public float $latitude;

    public ?int $altitude = null;

    #[Length(min: 1, max: 50)]
    public ?string $type = null;

}