<?php

declare(strict_types=1);

namespace App\Tests\Unit\Action\Currency\Delete;

use App\Action\Currency\Delete\DeleteCurrencyActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteCurrencyActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid4();

        $actual = new DeleteCurrencyActionRequest($id->toString());

        $this->assertEquals($id, $actual->id);
    }
}