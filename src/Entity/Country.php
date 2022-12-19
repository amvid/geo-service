<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CountryRepository;
use App\Trait\PositionTrait;
use App\Trait\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Country
{
    use TimestampTrait, PositionTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Region $region;

    #[ORM\ManyToMany(targetEntity: Timezone::class)]
    private Collection $timezones;

//    #[ORM\ManyToOne]
//    #[ORM\JoinColumn(nullable: false)]
//    private Currency $currency;

//    #[ORM\ManyToOne]
//    #[ORM\JoinColumn(nullable: false)]
//    private City $capital;

    #[ORM\Column(length: 150, unique: true, nullable: false)]
    private string $title;

    #[ORM\Column(length: 150, unique: true, nullable: false)]
    private string $nativeTitle;

    #[ORM\Column(length: 2, unique: true, nullable: false)]
    private string $ISO2;

    #[ORM\Column(length: 3, unique: true, nullable: false)]
    private string $ISO3;

    #[ORM\Column(length: 3, unique: true, nullable: false)]
    private string $numericCode;

    #[ORM\Column(length: 20, unique: true, nullable: false)]
    private string $phoneCode;

    #[ORM\Column(length: 100, unique: true, nullable: false)]
    private string $flag;

    #[ORM\Column(length: 20, nullable: false)]
    private string $tld;

    public function __construct(?UuidInterface $id = null)
    {
        if ($id) {
            $this->id = $id;
        }

        $this->timezones = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): self
    {
        $this->region = $region;

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

    public function getISO2(): string
    {
        return $this->ISO2;
    }

    public function setISO2(string $ISO2): self
    {
        $this->ISO2 = $ISO2;

        return $this;
    }

    public function getISO3(): string
    {
        return $this->ISO3;
    }

    public function setISO3(string $ISO3): self
    {
        $this->ISO3 = $ISO3;

        return $this;
    }

    public function getTimezones(): Collection
    {
        return $this->timezones;
    }

    public function addTimezone(Timezone $timezone): self
    {
        if (!$this->timezones->contains($timezone)) {
            $this->timezones->add($timezone);
        }

        return $this;
    }

    public function removeTimezone(Timezone $timezone): self
    {
        $this->timezones->removeElement($timezone);

        return $this;
    }
}
