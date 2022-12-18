<?php

declare(strict_types=1);

namespace App\Action\Region\Get;

use Symfony\Component\Validator\Constraints\Range;

class GetRegionsActionRequest
{
    public const DEFAULT_LIMIT = 500;
    public const DEFAULT_OFFSET = 0;

    #[Range(min: 1)]
    public int $limit = self::DEFAULT_LIMIT;

    #[Range(min: 0)]
    public int $offset = self::DEFAULT_OFFSET;

    public ?string $title = null;

    public static function fromArray(array $params): self
    {
        $req = new self();

        $req->limit = array_key_exists('limit', $params) && is_numeric($params['limit'])
            ? (int)$params['limit']
            : self::DEFAULT_LIMIT;

        $req->offset = array_key_exists('offset', $params) && is_numeric($params['offset'])
            ? (int)$params['offset']
            : self::DEFAULT_OFFSET;

        $req->title = $params['title'] ?? null;

        return $req;
    }
}