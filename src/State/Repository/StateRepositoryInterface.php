<?php

declare(strict_types=1);

namespace App\State\Repository;

use App\Country\Entity\Country;
use App\State\Entity\State;
use Ramsey\Uuid\UuidInterface;

interface StateRepositoryInterface
{
    public function findById(UuidInterface $id): ?State;

    public function save(State $state, bool $flush = false): void;

    public function remove(State $state, bool $flush = false): void;

    public function findByTitle(string $title): array;

    public function findByCode(string $code): ?State;

    public function list(
        int      $offset,
        int      $limit,
        ?string  $code = null,
        ?string  $title = null,
        ?string  $type = null,
        ?Country $country = null,
    ): array;
}