<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Update;

use App\Timezone\Action\Update\UpdateTimezoneActionRequest;
use PHPUnit\Framework\TestCase;

class UpdateTimezoneActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $actual = new UpdateTimezoneActionRequest();
        $actual->setTitle($title);
        $actual->setCode($code);
        $actual->setUtc($utc);

        $this->assertEquals($title, $actual->title);
        $this->assertEquals($code, $actual->code);
        $this->assertEquals($utc, $actual->utc);
    }
}
