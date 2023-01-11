<?php

declare(strict_types=1);

namespace App\Application\Controller\Request;

use Symfony\Component\Validator\Constraints\Range;

trait LimitOffsetRequestTrait
{
    #[Range(min: 1)]
    public int $limit = LimitOffsetInterface::DEFAULT_LIMIT;

    #[Range(min: 0)]
    public int $offset = LimitOffsetInterface::DEFAULT_OFFSET;

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
