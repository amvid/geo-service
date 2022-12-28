<?php

declare(strict_types=1);

namespace App\Tests\Unit\SubRegion\Action\Delete;

use App\SubRegion\Action\Delete\DeleteSubRegionActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteSubRegionActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();

        $actual = new DeleteSubRegionActionRequest($id->toString());

        $this->assertEquals($id, $actual->id);
    }
}