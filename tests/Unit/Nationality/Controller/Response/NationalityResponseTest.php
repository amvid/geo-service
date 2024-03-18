<?php

declare(strict_types=1);

namespace App\Tests\Unit\nationality\Controller\Response;

use App\Nationality\Controller\Response\NationalityResponse;
use App\Tests\Unit\Nationality\NationalityDummy;
use PHPUnit\Framework\TestCase;

class nationalityResponseTest extends TestCase
{
    public function testValidInstantiation(): void
    {
        $nationality = NationalityDummy::get();
        $actual = new NationalityResponse($nationality);

        $this->assertEquals($nationality->getId(), $actual->id);
        $this->assertEquals($nationality->getTitle(), $actual->title);
    }
}
