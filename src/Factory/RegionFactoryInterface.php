<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Region;

interface RegionFactoryInterface
{
    public function setTitle(string $title): self;
    public function setRegion(Region $region): self;
    public function create(): Region;
}