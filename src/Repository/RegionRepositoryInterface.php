<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Region;
use Ramsey\Uuid\UuidInterface;

interface RegionRepositoryInterface
{
    public function findById(UuidInterface $id): ?Region;
    public function save(Region $region, bool $flush = false): void;
    public function remove(Region $region, bool $flush = false): void;
    public function findByTitle(string $title): ?Region;
    public function list(int $offset, int $limit, ?string $title): array;
}