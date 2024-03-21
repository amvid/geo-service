<?php

declare(strict_types=1);

namespace App\City\Repository;

use App\City\Entity\City;
use App\Country\Entity\Country;
use App\State\Entity\State;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
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

    public function findByTitleAndCountry(string $title, Country $country): ?City
    {
        return $this->findOneBy(['title' => $title, 'country' => $country]);
    }

    public function findByTitle(string $title): iterable
    {
        return $this->findBy(['title' => $title]);
    }

    public function list(
        int $offset,
        int $limit,
        ?UuidInterface $id = null,
        ?string $title = null,
        ?State $state = null,
        ?Country $country = null,
    ): iterable {
        if ($id) {
            return $this->findBy(['id' => $id]);
        }

        $qb = $this->createQueryBuilder('c')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->where('1=1');

        $params = new ArrayCollection();

        if ($title) {
            $params->add(new Parameter('title', "%$title%"));
            $qb->andWhere('c.title LIKE :title');
        }

        if ($country) {
            $params->add(new Parameter('country', $country));
            $qb->andWhere('c.country = :country');
        }

        if ($state) {
            $params->add(new Parameter('state', $state));
            $qb->andWhere('c.state = :state');
        }

        return $qb
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }
}
