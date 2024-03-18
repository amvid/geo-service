<?php

declare(strict_types=1);

namespace App\Nationality\Repository;

use App\Nationality\Entity\Nationality;
use Ramsey\Uuid\UuidInterface;

interface NationalityRepositoryInterface
{
    public function findById(UuidInterface $id): ?Nationality;
    public function save(Nationality $nationality, bool $flush = false): void;
    public function remove(Nationality $nationality, bool $flush = false): void;
    public function findByTitle(string $title): ?Nationality;
    public function list(int $offset, int $limit, ?string $title): array;
}
