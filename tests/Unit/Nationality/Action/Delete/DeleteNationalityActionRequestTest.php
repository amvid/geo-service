<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Delete;

use App\Nationality\Action\Delete\DeleteNationalityActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteNationalityActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();

        $actual = new DeleteNationalityActionRequest($id->toString());

        $this->assertEquals($id, $actual->id);
    }
}
