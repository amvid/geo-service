<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Country;
use Ramsey\Uuid\UuidInterface;

interface CountryRepositoryInterface
{
    public function save(Country $country, bool $flush = false): void;

    public function remove(Country $country, bool $flush = false): void;

    public function findById(UuidInterface $id): ?Country;

    public function findByTitle(string $title): ?Country;

    public function findByISO3(string $iso3): ?Country;

    public function findByISO2(string $iso2): ?Country;
}