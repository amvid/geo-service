<?php

declare(strict_types=1);

namespace App\City\Entity;

use App\Application\Trait\PositionTrait;
use App\Application\Trait\TimestampTrait;
use App\City\Repository\CityRepository;
use App\Country\Entity\Country;
use App\State\Entity\State;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'city_title__country_unique', columns: ['country_id', 'title'])]
#[ORM\Index(columns: ['title'], name: 'city_search_idx')]
#[UniqueEntity('iata')]
class City
{
    use TimestampTrait;
    use PositionTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\ManyToOne(fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private Country $country;

    #[ORM\ManyToOne(fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    private ?State $state = null;

    #[ORM\Column(length: 150, nullable: false)]
    private string $title;

    #[ORM\Column(length: 3, nullable: true, unique: true)]
    private ?string $iata = null;

    public function __construct(?UuidInterface $id = null)
    {
        if ($id) {
            $this->id = $id;
        }
    }

    public function __toString(): string
    {
        return "$this->title ({$this->country->getTitle()})";
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getIata(): ?string
    {
        return $this->iata;
    }

    public function setIata(?string $iata): self
    {
        $this->iata = $iata;
        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;
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
