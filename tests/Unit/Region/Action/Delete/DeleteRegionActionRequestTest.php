<?php

declare(strict_types=1);

namespace App\Tests\Unit\Region\Action\Delete;

use App\Region\Action\Delete\DeleteRegionActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteRegionActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();

        $actual = new DeleteRegionActionRequest($id->toString());

        $this->assertEquals($id, $actual->id);
    }
}
