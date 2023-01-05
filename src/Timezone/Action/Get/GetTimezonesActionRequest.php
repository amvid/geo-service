<?php

declare(strict_types=1);

namespace App\Timezone\Action\Get;

use App\Application\Controller\Request\LimitOffsetInterface;
use App\Application\Controller\Request\LimitOffsetParser;
use Symfony\Component\Validator\Constraints\Range;

class GetTimezonesActionRequest implements LimitOffsetInterface
{
    #[Range(min: 1)]
    public int $limit = LimitOffsetInterface::DEFAULT_LIMIT;

    #[Range(min: 0)]
    public int $offset = LimitOffsetInterface::DEFAULT_OFFSET;

    public ?string $title = null;

    public ?string $code = null;

    public ?string $utc = null;

    public static function fromArray(array $params): self
    {
        /** @var GetTimezonesActionRequest $req */
        $req = LimitOffsetParser::parse($params, new self());
        $req->title = $params['title'] ?? null;
        $req->code = $params['code'] ?? null;
        $req->utc = $params['utc'] ?? null;

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