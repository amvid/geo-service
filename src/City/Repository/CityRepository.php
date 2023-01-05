<?php

declare(strict_types=1);

namespace App\City\Repository;

use App\City\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CityRepository extends ServiceEntityRepository implements CityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function save(City $city, bool $flush = false): void
    {
        $this->getEntityManager()->persist($city);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(City $city, bool $flush = false): void
    {
        $this->getEntityManager()->remove($city);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(UuidInterface $id): ?City
    {
        return $this->find($id);
    }

    public function findByTitle(string $title): ?City
    {
        return $this->findOneBy(['title' => $title]);
    }
}