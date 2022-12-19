<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CountryRepository extends ServiceEntityRepository implements CountryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    public function save(Country $country, bool $flush = false): void
    {
        $this->getEntityManager()->persist($country);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Country $country, bool $flush = false): void
    {
        $this->getEntityManager()->remove($country);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(UuidInterface $id): ?Country
    {
        return $this->find($id);
    }

    public function findByTitle(string $title): ?Country
    {
        return $this->findOneBy(['title' => $title]);
    }

    public function findByISO3(string $iso3): ?Country
    {
        return $this->findOneBy(['ISO3' => $iso3]);
    }

    public function findByISO2(string $iso2): ?Country
    {
        return $this->findOneBy(['ISO2' => $iso2]);
    }
}
