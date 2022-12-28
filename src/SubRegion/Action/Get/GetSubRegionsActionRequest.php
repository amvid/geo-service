<?php

declare(strict_types=1);

namespace App\SubRegion\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints\Range;

class GetSubRegionsActionRequest implements LimitOffsetInterface
{
    #[Range(min: 1)]
    public int $limit = LimitOffsetParser::DEFAULT_LIMIT;

    #[Range(min: 0)]
    public int $offset = LimitOffsetParser::DEFAULT_OFFSET;

    public ?string $title = null;

    public ?UuidInterface $regionId = null;

    public static function fromArray(array $params): self
    {
        /** @var GetSubRegionsActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        $req->title = $params['title'] ?? null;

        if (isset($params['regionId'])) {
            $req->regionId = Uuid::fromString($params['regionId']);
        }

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