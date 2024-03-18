<?php

declare(strict_types=1);

namespace App\Tests\Unit\Nationality\Action\Update;

use App\Nationality\Action\Update\UpdateNationalityActionResponse;
use App\Nationality\Entity\Nationality;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateNationalityActionResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();
        $title = 'American';
        $nationality = new Nationality($id);
        $nationality->setTitle($title)->setCreatedAt();

        $actual = new UpdateNationalityActionResponse($nationality);

        $this->assertEquals($id, $actual->nationalityResponse->id);
        $this->assertEquals($title, $actual->nationalityResponse->title);
    }
}
