<?php

declare(strict_types=1);

namespace App\Action\Currency\Get;

use App\Controller\Request\LimitOffsetInterface;
use App\Controller\Request\LimitOffsetParser;
use Symfony\Component\Validator\Constraints\Range;

class GetCurrenciesActionRequest implements LimitOffsetInterface
{
    #[Range(min: 1)]
    public int $limit = LimitOffsetParser::DEFAULT_LIMIT;

    #[Range(min: 0)]
    public int $offset = LimitOffsetParser::DEFAULT_OFFSET;

    public ?string $name = null;

    public ?string $code = null;

    public ?string $symbol = null;

    public static function fromArray(array $params): self
    {
        /** @var GetCurrenciesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());
        $req->name = $params['name'] ?? null;
        $req->code = $params['code'] ?? null;
        $req->symbol = $params['symbol'] ?? null;

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