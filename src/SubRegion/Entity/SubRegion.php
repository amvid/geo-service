<?php

declare(strict_types=1);

namespace App\SubRegion\Entity;

use App\Application\Trait\TimestampTrait;
use App\Region\Entity\Region;
use App\SubRegion\Repository\SubRegionRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SubRegionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('title')]
class SubRegion
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\ManyToOne(fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private Region $region;

    #[ORM\Column(length: 150, unique: true)]
    private string $title;

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

    public function getId(): UuidInterface
    {
        return $this->id;
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

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function setRegion(Region $region): self
    {
        $this->region = $region;
        return $this;
    }
}
