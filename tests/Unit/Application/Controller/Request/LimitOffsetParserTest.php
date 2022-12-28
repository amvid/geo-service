<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Controller\Request;

use App\Application\Controller\Request\LimitOffsetParser;
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

    public function testShouldReturnDefaultValuesOnEmptyLimitAndOffset(): void
    {
        $actual = LimitOffsetParser::parse([], new LimitOffsetRequestTestClass());

        $this->assertEquals(LimitOffsetParser::DEFAULT_LIMIT, $actual->getLimit());
        $this->assertEquals(LimitOffsetParser::DEFAULT_OFFSET, $actual->getOffset());
    }

    public function testShouldReturnDefaultValuesOnInvalidLimitAndOffset(): void
    {
        $params = [
            'limit' => '1o',
            'offset' => 'o'
        ];

        $actual = LimitOffsetParser::parse($params, new LimitOffsetRequestTestClass());

        $this->assertEquals(LimitOffsetParser::DEFAULT_LIMIT, $actual->getLimit());
        $this->assertEquals(LimitOffsetParser::DEFAULT_OFFSET, $actual->getOffset());
    }
}