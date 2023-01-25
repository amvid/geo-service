<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Controller\Response;

use App\Tests\Unit\Timezone\TimezoneDummy;
use App\Timezone\Controller\Response\TimezoneResponse;
use PHPUnit\Framework\TestCase;

class TimezoneResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $timezone = TimezoneDummy::get();
        $actual = new TimezoneResponse($timezone);

        $this->assertEquals($timezone->getId(), $actual->id);
        $this->assertEquals($timezone->getTitle(), $actual->title);
        $this->assertEquals($timezone->getCode(), $actual->code);
        $this->assertEquals($timezone->getUtc(), $actual->utc);
    }
}
