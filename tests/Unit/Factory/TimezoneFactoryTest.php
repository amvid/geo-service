<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Factory\TimezoneFactory;
use App\Factory\TimezoneFactoryInterface;
use PHPUnit\Framework\TestCase;

class TimezoneFactoryTest extends TestCase
{
    private TimezoneFactoryInterface $timezoneFactory;

    protected function setUp(): void
    {
        $this->timezoneFactory = new TimezoneFactory();
    }

    public function testShouldReturnANewRegion(): void
    {
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $actual = $this->timezoneFactory
            ->setTitle($title)
            ->setCode($code)
            ->setUtc($utc)
            ->create();

        $this->assertEquals($title, $actual->getTitle());
        $this->assertEquals($code, $actual->getCode());
        $this->assertEquals($utc, $actual->getUtc());
    }
}