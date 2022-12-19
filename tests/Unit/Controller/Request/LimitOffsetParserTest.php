<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller\Request;

use App\Controller\Request\LimitOffsetParser;
use PHPUnit\Framework\TestCase;

class LimitOffsetParserTest extends TestCase
{
    public function testShouldReturnValidRequest(): void
    {
        $limit = 10;
        $offset = 0;
        $params = ['limit' => $limit, 'offset' => $offset];

        $actual = LimitOffsetParser::parse($params, new LimitOffsetRequestTestClass());

        $this->assertEquals($limit, $actual->getLimit());
        $this->assertEquals($offset, $actual->getOffset());
    }
}