<?php

declare(strict_types=1);

namespace App\Application\Controller\Request;

interface LimitOffsetInterface
{
    public const DEFAULT_LIMIT = 500;
    public const DEFAULT_OFFSET = 0;

    public function setLimit(int $limit): self;
    public function getLimit(): int;
    public function setOffset(int $offset): self;
    public function getOffset(): int;
}