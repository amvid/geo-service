<?php

declare(strict_types=1);

namespace App\Region\Factory;

use App\Region\Entity\Region;

interface RegionFactoryInterface
{
    public function setTitle(string $title): self;
    public function setRegion(Region $region): self;
    public function create(): Region;
}