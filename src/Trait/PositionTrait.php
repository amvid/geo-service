<?php

declare(strict_types=1);

namespace App\Trait;

use Doctrine\ORM\Mapping\Column;

trait PositionTrait
{
    #[Column(nullable: false)]
    private float $longitude;

    #[Column(nullable: false)]
    private float $latitude;

    #[Column(nullable: true)]
    private ?int $altitude = null;

    public function getAltitude(): int
    {
        return $this->altitude;
    }

    public function setAltitude(int $altitude): self
    {
        $this->altitude = $altitude;
        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

}