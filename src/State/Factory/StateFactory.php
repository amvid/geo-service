<?php

declare(strict_types=1);

namespace App\State\Factory;

use App\Country\Entity\Country;
use App\State\Entity\State;

class StateFactory implements StateFactoryInterface
{
    private State $state;

    public function __construct()
    {
        $this->state = new State();
    }

    public function setTitle(string $title): StateFactoryInterface
    {
        $this->state->setTitle($title);
        return $this;
    }

    public function setCode(string $code): StateFactoryInterface
    {
        $this->state->setCode($code);
        return $this;
    }

    public function setType(?string $type = null): StateFactoryInterface
    {
        $this->state->setType($type);
        return $this;
    }

    public function setLatitude(float $latitude): StateFactoryInterface
    {
        $this->state->setLatitude($latitude);
        return $this;
    }

    public function setLongitude(float $longitude): StateFactoryInterface
    {
        $this->state->setLongitude($longitude);
        return $this;
    }

    public function setState(State $state): StateFactoryInterface
    {
        $this->state = $state;
        return $this;
    }

    public function setCountry(Country $country): StateFactoryInterface
    {
        $this->state->setCountry($country);
        return $this;
    }

    public function create(): State
    {
        return $this->state;
    }
}