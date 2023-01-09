<?php

declare(strict_types=1);

namespace App\Country\Entity;

use App\Application\Trait\PositionTrait;
use App\Application\Trait\TimestampTrait;
use App\Country\Repository\CountryRepository;
use App\Currency\Entity\Currency;
use App\SubRegion\Entity\SubRegion;
use App\Timezone\Entity\Timezone;
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
    private SubRegion $subRegion;

    #[ORM\ManyToMany(targetEntity: Timezone::class, orphanRemoval: true)]
    private Collection $timezones;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Currency $currency;

    #[ORM\Column(length: 150, unique: true, nullable: false)]
    private string $title;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $nativeTitle = null;

    #[ORM\Column(length: 2, unique: true, nullable: false)]
    private string $iso2;

    #[ORM\Column(length: 3, unique: true, nullable: false)]
    private string $iso3;

    #[ORM\Column(length: 3, unique: true, nullable: false)]
    private string $numericCode;

    #[ORM\Column(length: 20, nullable: false)]
    private string $phoneCode;

    #[ORM\Column(length: 100, nullable: false)]
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

    public function getSubRegion(): SubRegion
    {
        return $this->subRegion;
    }

    public function setSubRegion(SubRegion $subRegion): self
    {
        $this->subRegion = $subRegion;

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

    public function getIso2(): string
    {
        return $this->iso2;
    }

    public function setIso2(string $iso2): self
    {
        $this->iso2 = $iso2;

        return $this;
    }

    public function getIso3(): string
    {
        return $this->iso3;
    }

    public function setIso3(string $iso3): self
    {
        $this->iso3 = $iso3;

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

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getNativeTitle(): ?string
    {
        return $this->nativeTitle;
    }

    public function setNativeTitle(?string $nativeTitle = null): self
    {
        $this->nativeTitle = $nativeTitle;
        return $this;
    }

    public function getNumericCode(): string
    {
        return $this->numericCode;
    }

    public function setNumericCode(string $numericCode): self
    {
        $this->numericCode = $numericCode;
        return $this;
    }

    public function getPhoneCode(): string
    {
        return $this->phoneCode;
    }

    public function setPhoneCode(string $phoneCode): self
    {
        $this->phoneCode = $phoneCode;
        return $this;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): self
    {
        $this->flag = $flag;
        return $this;
    }

    public function getTld(): string
    {
        return $this->tld;
    }

    public function setTld(string $tld): self
    {
        $this->tld = $tld;
        return $this;
    }

}
