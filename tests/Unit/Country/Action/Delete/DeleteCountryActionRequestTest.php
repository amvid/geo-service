<?php

declare(strict_types=1);

namespace App\Tests\Unit\Country\Action\Delete;

use App\Country\Action\Delete\DeleteCountryActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCountryActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();

        $actual = new DeleteCountryActionRequest($id->toString());

        $this->assertEquals($id, $actual->id);
    }
}
