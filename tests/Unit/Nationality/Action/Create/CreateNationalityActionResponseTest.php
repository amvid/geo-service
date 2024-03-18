<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Create;

use App\Nationality\Action\Create\CreateNationalityActionResponse;
use App\Nationality\Entity\Nationality;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateNationalityActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();
        $title = 'American';

        $nationality = new Nationality($id);
        $nationality->setTitle($title);
        $nationality->setCreatedAt();

        $actual = new CreateNationalityActionResponse($nationality);

        $this->assertEquals($id, $actual->nationalityResponse->id);
        $this->assertEquals($title, $actual->nationalityResponse->title);
    }
}
