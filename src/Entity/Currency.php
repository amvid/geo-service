<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CurrencyRepository;
use App\Trait\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Currency
{
    use TimestampTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    #[ORM\Column(length: 3, unique: true)]
    private string $code;

    #[ORM\Column(length: 100, unique: true)]
    private string $name;

    #[ORM\Column(length: 10)]
    private string $symbol;

    public function __construct(?UuidInterface $id = null)
    {
        if ($id) {
            $this->id = $id;
        }
    }

    public function __toString(): string
    {
        return $this->code;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }
}
