<?php

declare(strict_types=1);

namespace App\Timezone\Repository;

use App\Timezone\Entity\Timezone;
use Ramsey\Uuid\UuidInterface;

interface TimezoneRepositoryInterface
{
    public function save(Timezone $timezone, bool $flush = false): void;

    public function remove(Timezone $timezone, bool $flush = false): void;

    public function findById(UuidInterface $id): ?Timezone;

    public function findByTitle(string $title): ?Timezone;

    public function findByCode(string $code): ?Timezone;

    public function list(
        int     $offset,
        int     $limit,
        ?string $title = null,
        ?string $code = null,
        ?string $utc = null
    ): array;

}