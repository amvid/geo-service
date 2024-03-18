<?php

declare(strict_types=1);

namespace App\Nationality\Factory;

use App\Nationality\Entity\Nationality;

interface NationalityFactoryInterface
{
    public function setTitle(string $title): self;
    public function setNationality(Nationality $nationality): self;
    public function create(): Nationality;
}
