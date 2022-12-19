<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Currency;
use Ramsey\Uuid\UuidInterface;

interface CurrencyRepositoryInterface
{
    public function save(Currency $currency, bool $flush = false): void;
    public function remove(Currency $currency, bool $flush = false): void;
    public function findById(UuidInterface $id): ?Currency;
    public function findByCode(string $code): ?Currency;
}