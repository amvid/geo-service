<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Get;

use App\Nationality\Action\Get\GetNationalitiesActionResponse;
use App\Nationality\Entity\Nationality;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetNationalitiesActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id1 = Uuid::uuid7();
        $id2 = Uuid::uuid7();

        $american = new Nationality($id1);
        $american->setTitle('American')->setCreatedAt();
        $norwegian = new Nationality($id2);
        $norwegian->setTitle('Norwegian')->setCreatedAt();

        $actual = new GetNationalitiesActionResponse([$american, $norwegian]);

        $this->assertCount(2, $actual->response);
        $this->assertEquals($american->getId(), $actual->response[0]->id);
        $this->assertEquals($norwegian->getId(), $actual->response[1]->id);
    }
}
