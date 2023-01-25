<?php

declare(strict_types=1);

namespace App\Application\Trait;

use Symfony\Component\Validator\Constraints\NotBlank;

trait PositionRequestTrait
{
    #[NotBlank]
    public float $longitude;

    #[NotBlank]
    public float $latitude;

    public ?int $altitude = null;
}
