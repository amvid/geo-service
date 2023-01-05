<?php

declare(strict_types=1);

namespace App\City\Repository;

use App\City\Entity\City;
use Ramsey\Uuid\UuidInterface;

interface CityRepositoryInterface
{
    public function save(City $city, bool $flush = false): void;

    public function remove(City $city, bool $flush = false): void;

    public function findById(UuidInterface $id): ?City;

    public function findByTitle(string $title): ?City;
}