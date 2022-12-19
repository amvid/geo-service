<?php

declare(strict_types=1);

namespace App\Controller\Request;

class LimitOffsetParser
{
    public const DEFAULT_LIMIT = 500;
    public const DEFAULT_OFFSET = 0;

    public static function parse(array $params, LimitOffsetInterface $request): LimitOffsetInterface
    {
        $request->setLimit(array_key_exists('limit', $params) && is_numeric($params['limit'])
            ? (int)$params['limit']
            : self::DEFAULT_LIMIT);

        $request->setOffset(array_key_exists('offset', $params) && is_numeric($params['offset'])
            ? (int)$params['offset']
            : self::DEFAULT_OFFSET);

        return $request;
    }
}