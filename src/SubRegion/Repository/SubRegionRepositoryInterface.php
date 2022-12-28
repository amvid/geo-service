<?php

declare(strict_types=1);

namespace App\SubRegion\Repository;

use App\SubRegion\Entity\SubRegion;
use Ramsey\Uuid\UuidInterface;

interface SubRegionRepositoryInterface
{
    public function findById(UuidInterface $id): ?SubRegion;
    public function save(SubRegion $subRegion, bool $flush = false): void;
    public function remove(SubRegion $subRegion, bool $flush = false): void;
    public function findByTitle(string $title): ?SubRegion;
    public function list(int $offset, int $limit, ?string $title, ?UuidInterface $regionId): array;
}