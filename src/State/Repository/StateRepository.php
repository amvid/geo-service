<?php

declare(strict_types=1);

namespace App\State\Repository;

use App\Country\Entity\Country;
use App\State\Entity\State;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class StateRepository extends ServiceEntityRepository implements StateRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, State::class);
    }

    public function save(State $state, bool $flush = false): void
    {
        $this->getEntityManager()->persist($state);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(State $state, bool $flush = false): void
    {
        $this->getEntityManager()->remove($state);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByTitle(string $title): array
    {
        return $this->findBy(['title' => $title]);
    }

    public function findByCode(string $code): ?State
    {
        return $this->findOneBy(['code' => $code]);
    }

    public function list(
        int $offset,
        int $limit,
        ?string $code = null,
        ?string $title = null,
        ?string $type = null,
        ?Country $country = null
    ): array
    {
        if ($code) {
            return $this->findBy(['code' => $code]);
        }

        if ($country) {
            return $this->findBy(['country' => $country]);
        }

        $qb = $this->createQueryBuilder('s')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->where('1=1');

        $params = [];

        if ($type) {
            $params['type'] = "%$type%";
            $qb->andWhere('s.type LIKE :type');
        }

        if ($title) {
            $params['title'] = "%title%";
            $qb->andWhere('s.title LIKE :title');
        }

        return $qb
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }

    public function findById(UuidInterface $id): ?State
    {
        return $this->find($id);
    }

}
