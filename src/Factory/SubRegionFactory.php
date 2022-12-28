<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\SubRegion;
use App\Region\Entity\Region;

class SubRegionFactory implements SubRegionFactoryInterface
{
    private SubRegion $subRegion;

    public function __construct()
    {
        $this->subRegion = new SubRegion();
    }

    public function setTitle(string $title): SubRegionFactoryInterface
    {
        $this->subRegion->setTitle($title);
        return $this;
    }

    public function create(): SubRegion
    {
        return $this->subRegion;
    }

    public function setRegion(Region $region): SubRegionFactoryInterface
    {
        $this->subRegion->setRegion($region);
        return $this;
    }

    public function setSubRegion(SubRegion $subRegion): SubRegionFactoryInterface
    {
        $this->subRegion = $subRegion;
        return $this;
    }
}