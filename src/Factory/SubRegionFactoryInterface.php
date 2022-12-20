<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Region;
use App\Entity\SubRegion;

interface SubRegionFactoryInterface
{
    public function setTitle(string $title): self;
    public function setSubRegion(SubRegion $subRegion): self;
    public function setRegion(Region $region): self;
    public function create(): SubRegion;
}