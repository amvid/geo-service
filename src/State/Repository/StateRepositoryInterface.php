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

    public function findByTitle(string $title): ?State;

    public function findByCode(string $code): iterable;

    public function list(
        int $offset,
        int $limit,
        ?UuidInterface $id = null,
        ?string $code = null,
        ?string $title = null,
        ?string $type = null,
        ?UuidInterface $countryId = null,
    ): array;
}
