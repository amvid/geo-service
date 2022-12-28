<?php

declare(strict_types=1);

namespace App\Region\Factory;

use App\Region\Entity\Region;

class RegionFactory implements RegionFactoryInterface
{
    private Region $region;

    public function __construct()
    {
        $this->region = new Region();
    }

    public function setTitle(string $title): RegionFactoryInterface
    {
        $this->region->setTitle($title);
        return $this;
    }

    public function create(): Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): RegionFactoryInterface
    {
        $this->region = $region;
        return $this;
    }
}