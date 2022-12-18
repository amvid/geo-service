<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Update;

use App\Action\Region\Update\UpdateRegionActionRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UpdateRegionActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::v1()->toRfc4122();
        $title = 'Europe';

        $actual = new UpdateRegionActionRequest();
        $actual->setId($id);
        $actual->setTitle($title);

        $this->assertEquals($id, $actual->id->toRfc4122());
        $this->assertEquals($title, $actual->title);
    }
}