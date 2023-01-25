<?php

declare(strict_types=1);

namespace App\Tests\Unit\State\Controller\Response;

use App\State\Controller\Response\StateResponse;
use App\Tests\Unit\State\StateDummy;
use PHPUnit\Framework\TestCase;

class StateResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $state = StateDummy::get();
        $actual = new StateResponse($state);

        $this->assertEquals($state->getId(), $actual->id);
        $this->assertEquals($state->getTitle(), $actual->title);
        $this->assertEquals($state->getCode(), $actual->code);
        $this->assertEquals($state->getLatitude(), $actual->latitude);
        $this->assertEquals($state->getLongitude(), $actual->longitude);
        $this->assertEquals($state->getAltitude(), $actual->altitude);
        $this->assertEquals($state->getType(), $actual->type);
        $this->assertEquals($state->getCountry()->getId(), $actual->country->id);
    }
}
