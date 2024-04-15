<?php

declare(strict_types=1);

namespace App\Airport\Entity;

use App\Airport\Repository\AirportRepository;
use App\Application\Trait\PositionTrait;
use App\Application\Trait\TimestampTrait;
use App\City\Entity\City;
use App\Timezone\Entity\Timezone;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('icao')]
#[UniqueEntity('iata')]
class Airport
{
    use TimestampTrait;
    use PositionTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private City $city;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Timezone $timezone;

    #[ORM\Column(length: 3, unique: true, nullable: false)]
    private string $iata;

    #[ORM\Column(length: 4, unique: true, nullable: false)]
    private string $icao;

    #[ORM\Column(length: 150, unique: false, nullable: false)]
    private string $title;

    #[ORM\Column(options: ['default' => true])]
    private bool $isActive = true;

    public function __construct(?UuidInterface $id = null)
    {
        if ($id) {
            $this->id = $id;
        }
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getTimezone(): Timezone
    {
        return $this->timezone;
    }

    public function setTimezone(Timezone $timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }

    public function getIata(): string
    {
        return $this->iata;
    }

    public function setIata(string $iata): self
    {
        $this->iata = $iata;
        return $this;
    }

    public function getIcao(): string
    {
        return $this->icao;
    }

    public function setIcao(string $icao): self
    {
        $this->icao = $icao;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
