<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Update;

use App\Nationality\Action\Update\UpdateNationalityActionRequest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateNationalityActionRequestTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();
        $title = 'American';

        $actual = new UpdateNationalityActionRequest();
        $actual->setId($id->toString());
        $actual->setTitle($title);

        $this->assertEquals($id, $actual->id);
        $this->assertEquals($title, $actual->title);
    }
}
