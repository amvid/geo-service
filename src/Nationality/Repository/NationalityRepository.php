<?php

declare(strict_types=1);

namespace App\Nationality\Repository;

use App\Nationality\Entity\Nationality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class NationalityRepository extends ServiceEntityRepository implements NationalityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nationality::class);
    }

    public function save(Nationality $nationality, bool $flush = false): void
    {
        $this->getEntityManager()->persist($nationality);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Nationality $nationality, bool $flush = false): void
    {
        $this->getEntityManager()->remove($nationality);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByTitle(string $title): ?Nationality
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

    public function findById(UuidInterface $id): ?Nationality
    {
        return $this->find($id);
    }
}
