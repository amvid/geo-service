<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Timezone\Update;

use App\Action\Timezone\Update\UpdateTimezoneActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateTimezoneActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();
        $title = 'Europe/Oslo (GMT+01:00)';
        $code = 'Europe/Oslo';
        $utc = '+01:00';

        $actual = new UpdateTimezoneActionRequest();
        $actual->setId($id->toString());
        $actual->setTitle($title);
        $actual->setCode($code);
        $actual->setUtc($utc);

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
        $this->assertEquals($code, $actual->code);
        $this->assertEquals($utc, $actual->utc);
    }
}