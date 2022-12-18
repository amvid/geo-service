<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Update;

use App\Action\Region\Update\UpdateRegionActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateRegionActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();
        $title = 'Europe';

        $actual = new UpdateRegionActionRequest();
        $actual->setId($id->toString());
        $actual->setTitle($title);

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
    }
}