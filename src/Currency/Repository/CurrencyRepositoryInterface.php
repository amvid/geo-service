<?php

declare(strict_types=1);

namespace App\Currency\Repository;

use App\Currency\Entity\Currency;
use Ramsey\Uuid\UuidInterface;

interface CurrencyRepositoryInterface
{
    public function save(Currency $currency, bool $flush = false): void;
    public function remove(Currency $currency, bool $flush = false): void;
    public function findById(UuidInterface $id): ?Currency;
    public function findByCode(string $code): ?Currency;

    public function list(
        int $offset,
        int $limit,
        ?string $name = null,
        ?string $code = null,
        ?string $symbol = null,
    ): array;
}