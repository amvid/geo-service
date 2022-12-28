<?php

declare(strict_types=1);

namespace App\SubRegion\Repository;

use App\SubRegion\Entity\SubRegion;
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

    public function list(int $offset, int $limit, ?string $title = null, ?UuidInterface $regionId = null): array
    {
        $qb = $this->createQueryBuilder('s')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->where('1=1');

        $params = [];

        if ($title) {
            $params['title'] = "%$title%";
            $qb->andWhere('s.title LIKE :title');
        }

        if ($regionId) {
            $params['regionId'] = $regionId;
            $qb->andWhere('s.region = :regionId');
        }

        return $qb->setParameters($params)->getQuery()->getResult();
    }

    public function findById(UuidInterface $id): ?SubRegion
    {
        return $this->find($id);
    }

}
