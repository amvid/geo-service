<?php

declare(strict_types=1);

namespace App\Region\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use Symfony\Component\Validator\Constraints\Range;

class GetRegionsActionRequest implements LimitOffsetInterface
{
    #[Range(min: 1)]
    public int $limit = LimitOffsetParser::DEFAULT_LIMIT;

    #[Range(min: 0)]
    public int $offset = LimitOffsetParser::DEFAULT_OFFSET;

    public ?string $title = null;

    public static function fromArray(array $params): self
    {
        /** @var GetRegionsActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());

        $req->title = $params['title'] ?? null;

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