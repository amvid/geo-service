<?php

declare(strict_types=1);

namespace App\State\Factory;

use App\Country\Entity\Country;
use App\State\Entity\State;

interface StateFactoryInterface
{
    public function setTitle(string $title): self;

    public function setCode(string $code): self;

    public function setType(?string $type = null): self;

    public function setLatitude(float $latitude): self;

    public function setLongitude(float $longitude): self;

    public function setState(State $state): self;

    public function setCountry(Country $country): self;

    public function create(): State;
}