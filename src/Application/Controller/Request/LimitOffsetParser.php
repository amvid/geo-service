<?php

declare(strict_types=1);

namespace App\Application\Controller\Request;

class LimitOffsetParser
{
    public static function parse(array $params, LimitOffsetInterface $request): LimitOffsetInterface
    {
        $request->setLimit(array_key_exists('limit', $params) && is_numeric($params['limit'])
            ? (int)$params['limit']
            : LimitOffsetInterface::DEFAULT_LIMIT);

        $request->setOffset(array_key_exists('offset', $params) && is_numeric($params['offset'])
            ? (int)$params['offset']
            : LimitOffsetInterface::DEFAULT_OFFSET);

        return $request;
    }
}
