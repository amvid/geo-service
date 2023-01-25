<?php

declare(strict_types=1);

namespace App\Timezone\Repository;

use App\Timezone\Entity\Timezone;
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

    public function list(
        int $offset,
        int $limit,
        ?string $title = null,
        ?string $code = null,
        ?string $utc = null
    ): array {
        $qb = $this->createQueryBuilder('t')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->where('1=1');

        $params = [];

        if ($title) {
            $params['title'] = "%$title%";
            $qb->andWhere('t.title LIKE :title');
        }

        if ($code) {
            $params['code'] = "%$code%";
            $qb->andWhere('t.code LIKE :code');
        }

        if ($utc) {
            $utc = trim($utc);
            $params['utc'] = "%$utc%";
            $qb->andWhere('t.utc LIKE :utc');
        }

        return $qb
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }
}
