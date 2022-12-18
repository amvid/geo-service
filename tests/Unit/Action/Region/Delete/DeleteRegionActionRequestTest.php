<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Region\Delete;

use App\Action\Region\Delete\DeleteRegionActionRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DeleteRegionActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::v1()->toRfc4122();

        $actual = new DeleteRegionActionRequest($id);

        $this->assertEquals($id, $actual->id->toRfc4122());
    }
}