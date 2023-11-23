<?php

declare(strict_types=1);

namespace App\Country\Repository;

use App\Country\Entity\Country;
use App\Currency\Entity\Currency;
use App\SubRegion\Entity\SubRegion;
use Ramsey\Uuid\UuidInterface;

interface CountryRepositoryInterface
{
    public function save(Country $country, bool $flush = false): void;

    public function remove(Country $country, bool $flush = false): void;

    public function findById(UuidInterface $id): ?Country;

    public function findByTitle(string $title): ?Country;

    public function findByIso3(string $iso3): ?Country;

    public function findByIso2(string $iso2): ?Country;

    public function findPhoneCodes(
        int $offset,
        int $limit,
        ?string $title,
        ?string $iso2,
        ?string $iso3,
        ?string $phoneCode,
    ): array;

    public function list(
        int $offset,
        int $limit,
        ?UuidInterface $id,
        ?string $title,
        ?string $nativeTitle,
        ?string $iso2,
        ?string $iso3,
        ?string $phoneCode,
        ?string $numericCode,
        ?string $tld,
        ?Currency $currency,
        ?SubRegion $subRegion,
    ): array;
}
