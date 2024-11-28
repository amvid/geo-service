<?php

declare(strict_types=1);

namespace App\Country\Repository;

use App\Country\Entity\Country;
use App\Currency\Entity\Currency;
use App\SubRegion\Entity\SubRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use Ramsey\Uuid\UuidInterface;

class CountryRepository extends ServiceEntityRepository implements CountryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    public function save(Country $country, bool $flush = false): void
    {
        $this->getEntityManager()->persist($country);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Country $country, bool $flush = false): void
    {
        $this->getEntityManager()->remove($country);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(UuidInterface $id): ?Country
    {
        return $this->find($id);
    }

    public function findByTitle(string $title): ?Country
    {
        return $this->findOneBy(['title' => $title]);
    }

    public function findByIso3(string $iso3): ?Country
    {
        return $this->findOneBy(['iso3' => $iso3]);
    }

    public function findByIso2(string $iso2): ?Country
    {
        return $this->findOneBy(['iso2' => $iso2]);
    }

    public function findPhoneCodes(
        int $offset,
        int $limit,
        ?string $title,
        ?string $phoneCode,
    ): array {
        $qb = $this->createQueryBuilder('c')->where('1=1');

        $params = new ArrayCollection();

        if ($title) {
            $params->add(new Parameter('title', "$title%"));
            $qb->andWhere('c.title LIKE :title');
        }

        if ($phoneCode) {
            $params->add(new Parameter('phoneCode', "$phoneCode%"));
            $qb->andWhere('c.phoneCode LIKE :phoneCode');
        }

        return $qb
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }

    public function list(
        int $offset,
        int $limit,
        ?UuidInterface $id,
        ?string $title,
        ?string $nativeTitle,
        ?string $iso2,
        ?string $iso3,
        ?string $phoneCode,
        ?string $numericCode,
        ?string $tld,
        ?Currency $currency,
        ?SubRegion $subRegion,
    ): array {
        if ($id) {
            return $this->findBy(['id' => $id]);
        }

        if ($iso2) {
            return $this->findBy(['iso2' => $iso2]);
        }

        if ($iso3) {
            return $this->findBy(['iso3' => $iso3]);
        }

        if ($numericCode) {
            return $this->findBy(['numericCode' => $numericCode]);
        }

        $qb = $this->createQueryBuilder('c')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->where('1=1');

        $params = new ArrayCollection();

        if ($title) {
            $params->add(new Parameter('title', "%$title%"));
            $qb->andWhere('c.title LIKE :title');
        }

        if ($nativeTitle) {
            $params->add('nativeTitle', "%$nativeTitle%");
            $qb->andWhere('c.nativeTitle LIKE :nativeTitle');
        }

        if ($phoneCode) {
            $params->add('phoneCode', "%$phoneCode%");
            $qb->andWhere('c.phoneCode = :phoneCode');
        }

        if ($tld) {
            $params->add('tld', "%$tld%");
            $qb->andWhere('c.tld = :tld');
        }

        if ($currency) {
            $params->add('currency', "%$currency%");
            $qb->andWhere('c.currency = :currency');
        }

        if ($subRegion) {
            $params->add('subRegion', "%$subRegion%");
            $qb->andWhere('c.subRegion = :subRegion');
        }

        return $qb
            ->setParameters($params)
            ->getQuery()
            ->getResult();
    }
}
