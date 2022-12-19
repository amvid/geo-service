<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Request;

use App\Controller\Request\LimitOffsetInterface;

class LimitOffsetRequestTestClass implements LimitOffsetInterface
{
    private int $limit;

    private int $offset;

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