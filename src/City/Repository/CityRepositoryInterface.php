<?php

declare(strict_types=1);

namespace App\City\Repository;

use App\City\Entity\City;
use App\Country\Entity\Country;
use App\State\Entity\State;
use Ramsey\Uuid\UuidInterface;

interface CityRepositoryInterface
{
    public function save(City $city, bool $flush = false): void;

    public function remove(City $city, bool $flush = false): void;

    public function findById(UuidInterface $id): ?City;

    public function findByTitle(string $title): ?City;

    public function list(
        int            $offset,
        int            $limit,
        ?UuidInterface $id = null,
        ?string        $title = null,
        ?State         $state = null,
        ?Country       $country = null,
    ): iterable;
}