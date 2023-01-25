<?php

declare(strict_types=1);

namespace App\SubRegion\Factory;

use App\Region\Entity\Region;
use App\SubRegion\Entity\SubRegion;

interface SubRegionFactoryInterface
{
    public function setTitle(string $title): self;
    public function setSubRegion(SubRegion $subRegion): self;
    public function setRegion(Region $region): self;
    public function create(): SubRegion;
}
