<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SubRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class SubRegionRepository extends ServiceEntityRepository implements SubRegionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubRegion::class);
    }

    public function save(SubRegion $subRegion, bool $flush = false): void
    {
        $this->getEntityManager()->persist($subRegion);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SubRegion $subRegion, bool $flush = false): void
    {
        $this->getEntityManager()->remove($subRegion);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByTitle(string $title): ?SubRegion
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

    public function findById(UuidInterface $id): ?SubRegion
    {
        return $this->find($id);
    }

}
