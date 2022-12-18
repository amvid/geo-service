<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Timezone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class TimezoneRepository extends ServiceEntityRepository implements TimezoneRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timezone::class);
    }

    public function save(Timezone $timezone, bool $flush = false): void
    {
        $this->getEntityManager()->persist($timezone);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Timezone $timezone, bool $flush = false): void
    {
        $this->getEntityManager()->remove($timezone);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(UuidInterface $id): ?Timezone
    {
        return $this->find($id);
    }

    public function findByTitle(string $title): ?Timezone
    {
        return $this->findOneBy(['title' => $title]);
    }

    public function findByCode(string $code): ?Timezone
    {
        return $this->findOneBy(['code' => $code]);
    }
}
