<?php

declare(strict_types=1);

namespace App\Application\Trait;

trait OptionalPositionRequestTrait
{

    public ?float $longitude = null;

    public ?float $latitude = null;

    public ?int $altitude = null;
}