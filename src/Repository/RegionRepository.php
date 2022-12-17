<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RegionRepository extends ServiceEntityRepository implements RegionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Region::class);
    }

    public function save(Region $region, bool $flush = false): void
    {
        $this->getEntityManager()->persist($region);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Region $region, bool $flush = false): void
    {
        $this->getEntityManager()->remove($region);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByTitle(string $title): ?Region
    {
        return $this->findOneBy(['title' => $title]);
    }

    public function list(int $offset, int $limit, ?string $title): array
    {
        $qb = $this->createQueryBuilder('r')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        if ($title) {
            $qb->where('r.title LIKE :title')
                ->setParameter('title', "%$title%");
        }

        return $qb->getQuery()->getResult();
    }
}
