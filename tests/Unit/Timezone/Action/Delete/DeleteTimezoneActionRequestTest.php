<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timezone\Action\Delete;

use App\Timezone\Action\Delete\DeleteTimezoneActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteTimezoneActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();

        $actual = new DeleteTimezoneActionRequest($id->toString());

        $this->assertEquals($id, $actual->id);
    }
}
