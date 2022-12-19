<?php

declare(strict_types=1);

namespace App\Controller\Request;

interface LimitOffsetInterface
{
    public function setLimit(int $limit): self;
    public function getLimit(): int;
    public function setOffset(int $offset): self;
    public function getOffset(): int;
}