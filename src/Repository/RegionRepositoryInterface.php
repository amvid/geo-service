<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Region;

interface RegionRepositoryInterface
{
    public function save(Region $region): void;
    public function remove(Region $region): void;
    public function findByTitle(string $title): ?Region;
    public function list(int $offset, int $limit, ?string $title): array;
}