<?php

namespace App\Airport\Repository;

use App\Airport\Entity\Airport;
use App\City\Entity\City;
use App\Timezone\Entity\Timezone;
use Ramsey\Uuid\UuidInterface;

interface AirportRepositoryInterface
{
    public function save(Airport $airport, bool $flush = false): void;

    public function remove(Airport $airport, bool $flush = false): void;

    public function findById(UuidInterface $id): ?Airport;

    public function findByTitle(string $title): iterable;

    public function findByIata(string $iata): ?Airport;

    public function findByIcao(string $icao): ?Airport;

    public function list(
        int $offset,
        int $limit,
        ?UuidInterface $id = null,
        ?string $title = null,
        ?string $iata = null,
        ?string $icao = null,
        ?bool $isActive = null,
        ?Timezone $timezone = null,
        ?City $city = null,
    ): iterable;
}
