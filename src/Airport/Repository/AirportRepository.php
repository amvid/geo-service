<?php

declare(strict_types=1);

namespace App\Airport\Repository;

use App\Airport\Entity\Airport;
use App\City\Entity\City;
use App\Timezone\Entity\Timezone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class AirportRepository extends ServiceEntityRepository implements AirportRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Airport::class);
    }

    public function save(Airport $airport, bool $flush = false): void
    {
        $this->getEntityManager()->persist($airport);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Airport $airport, bool $flush = false): void
    {
        $this->getEntityManager()->remove($airport);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(UuidInterface $id): ?Airport
    {
        return $this->find($id);
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
        ?string $iata = null,
        ?string $icao = null,
        ?bool $isActive = null,
        ?Timezone $timezone = null,
        ?City $city = null,
    ): iterable {
        if ($id) {
            return $this->findBy(['id' => $id]);
        }

        $qb = $this
            ->createQueryBuilder('a')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->where('1=1');

        $params = new ArrayCollection();

        if ($title) {
            $qb->andWhere('a.title LIKE :title');
            $params->add(new Parameter('title', "%$title%"));
        }

        if ($iata) {
            $qb->andWhere('a.iata LIKE :iata');
            $params->add(new Parameter('iata', "%$iata%"));
        }

        if ($icao) {
            $qb->andWhere('a.icao LIKE :icao');
            $params->add(new Parameter('icao', "%$icao%"));
        }

        if ($timezone) {
            $qb->andWhere('a.timezone = :timezone');
            $params->add(new Parameter('timezone', $timezone));
        }

        if ($city) {
            $qb->andWhere('a.city = :city');
            $params->add(new Parameter('city', $city));
        }

        if (null !== $isActive) {
            $qb->andWhere('a.isActive = :isActive');
            $params->add(new Parameter('isActive', $isActive));
        }

        return $qb
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }

    public function query(int $offset, int $limit, string $query): iterable
    {
        $exactMatchParams = new ArrayCollection();
        $exactMatchParams->add(new Parameter('exactQuery', $query));
        $exactMatchParams->add(new Parameter('isActive', true));

        $exactMatchResult = $this->createQueryBuilder('a')
            ->join('a.city', 'c')
            ->join('c.country', 'co')
            ->where('a.iata = :exactQuery')
            ->andWhere('a.isActive = :isActive')
            ->setParameters($exactMatchParams)
            ->getQuery()
            ->getResult();

        if (count($exactMatchResult) > 0) {
            return $exactMatchResult;
        }

        $params = new ArrayCollection();
        $params->add(new Parameter('query', "$query%"));
        $params->add(new Parameter('isActive', true));

        return $this->createQueryBuilder('a')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->join('a.city', 'c')
            ->join('c.country', 'co')
            ->where('a.title LIKE :query')
            ->orWhere('a.iata LIKE :query')
            ->orWhere('a.icao LIKE :query')
            ->orWhere('c.title LIKE :query')
            ->orWhere('co.title LIKE :query')
            ->andWhere('a.isActive = :isActive')
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }

    public function findByIata(string $iata): ?Airport
    {
        return $this->findOneBy(['iata' => $iata]);
    }

    public function findByIcao(string $icao): ?Airport
    {
        return $this->findOneBy(['icao' => $icao]);
    }
}
