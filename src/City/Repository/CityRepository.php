<?php

declare(strict_types=1);

namespace App\City\Repository;

use App\City\Entity\City;
use App\Country\Entity\Country;
use App\State\Entity\State;
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

    public function list(
        int            $offset,
        int            $limit,
        ?UuidInterface $id = null,
        ?string        $title = null,
        ?State         $state = null,
        ?Country       $country = null,
    ): iterable
    {
        if ($id) {
            return $this->findBy(['id' => $id]);
        }

        $qb = $this->createQueryBuilder('c')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->where('1=1');

        $params = [];

        if ($title) {
            $params['title'] = "%$title%";
            $qb->andWhere('c.title LIKE :title');
        }

        if ($country) {
            $params['country'] = $country;
            $qb->andWhere('c.country = :country');
        }

        if ($state) {
            $params['state'] = $state;
            $qb->andWhere('c.state = :state');
        }

        return $qb
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }
}