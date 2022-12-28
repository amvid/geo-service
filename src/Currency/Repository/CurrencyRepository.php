<?php

declare(strict_types=1);

namespace App\Currency\Repository;

use App\Currency\Entity\Currency;
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

    public function list(
        int     $offset,
        int     $limit,
        ?string $name = null,
        ?string $code = null,
        ?string $symbol = null,
    ): array
    {
        $qb = $this->createQueryBuilder('c')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->where('1=1');

        $params = [];

        if ($name) {
            $params['name'] = "%$name%";
            $qb->andWhere('c.name LIKE :name');
        }

        if ($code) {
            $params['code'] = "%$code%";
            $qb->andWhere('c.code LIKE :code');
        }

        if ($symbol) {
            $params['symbol'] = "%$symbol%";
            $qb->andWhere('c.symbol LIKE :symbol');
        }

        return $qb
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }
}
