<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CurrencyRepository extends ServiceEntityRepository implements CurrencyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    public function save(Currency $currency, bool $flush = false): void
    {
        $this->getEntityManager()->persist($currency);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Currency $currency, bool $flush = false): void
    {
        $this->getEntityManager()->remove($currency);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(UuidInterface $id): ?Currency
    {
        return $this->find($id);
    }

    public function findByCode(string $code): ?Currency
    {
        return $this->findOneBy(['code' => $code]);
    }

}
