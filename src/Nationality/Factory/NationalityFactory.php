<?php

declare(strict_types=1);

namespace App\Nationality\Factory;

use App\Nationality\Entity\Nationality;

class NationalityFactory implements NationalityFactoryInterface
{
    private Nationality $nationality;

    public function __construct()
    {
        $this->nationality = new Nationality();
    }

    public function setTitle(string $title): NationalityFactoryInterface
    {
        $this->nationality->setTitle($title);
        return $this;
    }

    public function create(): Nationality
    {
        return $this->nationality;
    }

    public function setNationality(Nationality $nationality): NationalityFactoryInterface
    {
        $this->nationality = $nationality;
        return $this;
    }
}
