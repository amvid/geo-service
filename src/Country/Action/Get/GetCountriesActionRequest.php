<?php

declare(strict_types=1);

namespace App\Country\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Range;

class GetCountriesActionRequest implements LimitOffsetInterface
{
    #[Range(min: 1)]
    public int $limit = LimitOffsetInterface::DEFAULT_LIMIT;

    #[Range(min: 0)]
    public int $offset = LimitOffsetInterface::DEFAULT_OFFSET;

    public ?UuidInterface $id = null;
    public ?string $iso2 = null;
    public ?string $iso3 = null;
    public ?string $title = null;
    public ?string $nativeTitle = null;
    public ?string $phoneCode = null;
    public ?string $numericCode = null;
    public ?string $tld = null;
    public ?string $subRegion = null;
    public ?string $currencyCode = null;

    /**
     * ["Europe/Oslo", "Europe/Riga"]
     * @var array<string> $timezones
     */
    public ?array $timezones = null;

    public static function fromArray(array $params): self
    {
        /** @var GetCountriesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        if (isset($params['id'])) {
            $req->id = Uuid::fromString($params['id']);
        }

        $req->iso2 = $params['iso2'] ?? null;
        $req->iso3 = $params['iso3'] ?? null;
        $req->phoneCode = $params['phoneCode'] ?? null;
        $req->numericCode = $params['numericCode'] ?? null;
        $req->title = $params['title'] ?? null;
        $req->nativeTitle = $params['nativeTitle'] ?? null;
        $req->tld = $params['tld'] ?? null;
        $req->subRegion = $params['subRegion'] ?? null;
        $req->currencyCode = $params['currencyCode'] ?? null;
        $req->timezones = $params['timezones'] ?? null;

        return $req;
    }

    public function setLimit(int $limit): LimitOffsetInterface
    {
        $this->limit = $limit;
        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setOffset(int $offset): LimitOffsetInterface
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}