<?php

declare(strict_types=1);

namespace App\Tests\Unit\nationality\Entity;

use App\Nationality\Entity\Nationality;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class NationalityTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $id = Uuid::uuid7();
        $title = 'American';
        $nationality = new Nationality($id);
        $nationality->setTitle($title);
        $nationality->setCreatedAt();

        $this->assertEquals($title, $nationality->getTitle());
        $this->assertEquals($id, $nationality->getId());
        $this->assertNotNull($nationality->getCreatedAt());
        $this->assertNotNull($nationality->getUpdatedAt());
    }
}
