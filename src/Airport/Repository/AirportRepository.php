<?php

declare(strict_types=1);

namespace App\Airport\Repository;

use App\Airport\Entity\Airport;
use App\City\Entity\City;
use App\Timezone\Entity\Timezone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

        $params = [];

        if ($title) {
            $qb->andWhere('a.title LIKE :title');
            $params['title'] = "%$title%";
        }

        if ($iata) {
            $qb->andWhere('a.iata LIKE :iata');
            $params['iata'] = "%$iata%";
        }

        if ($icao) {
            $qb->andWhere('a.icao LIKE :icao');
            $params['icao'] = "%$icao%";
        }

        if ($timezone) {
            $qb->andWhere('a.timezone = :timezone');
            $params['timezone'] = $timezone;
        }

        if ($city) {
            $qb->andWhere('a.city = :city');
            $params['city'] = $city;
        }

        return $qb
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
