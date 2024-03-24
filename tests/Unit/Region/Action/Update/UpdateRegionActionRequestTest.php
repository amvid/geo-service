<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Action\Update;

use App\Region\Action\Update\UpdateRegionActionRequest;
use PHPUnit\Framework\TestCase;

class UpdateRegionActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $title = 'Europe';

        $actual = new UpdateRegionActionRequest();
        $actual->setTitle($title);

        $this->assertEquals($title, $actual->title);
    }
}
