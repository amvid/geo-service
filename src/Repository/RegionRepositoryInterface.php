<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Region;
use Symfony\Component\Uid\Uuid;

interface RegionRepositoryInterface
{
    public function findById(Uuid $id): ?Region;
    public function save(Region $region, bool $flush = false): void;
    public function remove(Region $region, bool $flush = false): void;
    public function findByTitle(string $title): ?Region;
    public function list(int $offset, int $limit, ?string $title): array;
}